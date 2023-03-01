<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Entities\Employee;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use App\Entities\Schedule;
use App\Entities\Todo;
use App\Entities\User;
use App\Enums\UserGender;
use App\Enums\UserType;
use App\Events\SampleFlushListener;

class SampleController extends BaseController
{
    public function __construct(
        private EntityManager $entityManager
    ) { }

    /**
     * Create list of schedules
     */
    public function createSchedules(): JsonResponse
    {
        $scheduleCount = 5;

        for ($i = 0; $i < $scheduleCount; $i++) {
            $schedule = new Schedule(
                date: new \DateTime,
                time: (new \DateTime)->setTime($i + 1, 0, 0),
            );

            $this->entityManager->persist($schedule);
        }
     
        $this->entityManager->flush();

        return Response::json(['message' => 'Schedules has been created']);
    }

    /**
     * Create a user
     */
    public function createUser(): JsonResponse
    {
        try {
            $user = new User(
                name  : Request::get('name'), 
                gender: UserGender::from(Request::get('gender')),
                type  : UserType::from(Request::get('type'))
            );
    
            $this->entityManager->persist($user);
            $this->entityManager->flush();
    
            return Response::json($user);
        } catch (UniqueConstraintViolationException $e) {
            return Response::json(['message' => 'The name provided name already exists.'], 400);
        }
    }

    /**
     * 
     * Add todo record for given user
     * 
     * @param int      $userId
     * @param int|null scheduleId
     * 
     */
    public function createUserTodo(string $userId): JsonResponse
    {
        $evm = $this->entityManager->getEventManager();
        $evm->addEventListener([Events::onFlush], new SampleFlushListener());
        /** @var User $user */
        $user       = $this->entityManager->find(User::class, $userId);
        $scheduleId = Request::get('schedule_id');

        if (empty($scheduleId) === false) {
            /** @var Schedule $schedule */
            $schedule = $this->entityManager->find(Schedule::class, $scheduleId);
        }

        $user->addTodo(new Todo(
            title: Request::get('title'),
            description: Request::get('description')
        ), $schedule ?? null);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return Response::json($user->todos->toArray());
    }

    /**
     * Use DQL to query all todo with their respective schedule and map the result to DTO TodoSchedule
     */
    public function sampleDqlWithDto(int $todoId): JsonResponse
    {
        $result = $this->entityManager
                    ->createQueryBuilder()
                    ->select(sprintf(
                        'NEW %s(t.title, t.description, ts.date, ts.time)',
                        \App\DTO\TodoSchedule::class
                    ))
                    ->from(Todo::class, 't')
                    ->leftJoin('t.schedules', 'ts')
                    ->where('t.id = ' . $todoId)
                    ->getQuery()
                    ->getResult();
        
        return Response::json($result);
    }

    /**
     * Filter users who has male as their gender value
     */
    public function getMaleUsers(): JsonResponse
    {
        return Response::json(
            $this->entityManager
                ->getRepository(User::class)
                ->getMaleUsers()
        );
    }

    /**
     * Filter users who has female as their gender
     */
    public function getFemaleUsers(): JsonResponse
    {
        return Response::json(
            $this->entityManager
                ->getRepository(User::class)
                ->getFemaleUsers()
        );
    }

    /**
     * Add "_e" on top any changes in the entity via event listener in "onFlush" event
     * Event listener is binded to the global EntityManager's event manager
     * via ServiceProvider named DataMapperServiceProvider
     */
    public function sampleEventListener(string $userId): JsonResponse
    {
        $user = $this->entityManager->find(User::class, $userId);
        if (!empty($user)) {
            $user->name = $user->name . '_c';
            $this->entityManager->flush();
            return Response::json($user);
        }

        throw new \Exception('User doesn\'t exists.', 404);
    }

    public function sampleCustomDataType(int $employeeId)
    {
        /** @var ?Employee $employee */
        $employee = $this->entityManager->find(Employee::class, $employeeId);

        if (!empty($employee)) {
            return Response::json($employee->money->getMoneyWithPesoCurrencySign());
        }

        throw new \Exception('Employee doesn\'t exists.', 404);
    }
}