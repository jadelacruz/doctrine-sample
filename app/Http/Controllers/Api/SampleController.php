<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Entities\Schedule;
use App\Entities\Todo;
use App\Entities\User;
use App\Enums\UserGender;
use App\Enums\UserType;
use Doctrine\DBAL\Exception\UniqueConstraintViolationException;
use Doctrine\ORM\EntityManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Response;

class SampleController extends BaseController
{
    public function __construct(
        private EntityManager $entityManager
    ) { }

    function test()
    {
        // $schedule1 = $entityManager->find(Schedule::class, 1);
        // $user      = new User(
        //     name  : 'Test Name', 
        //     gender: UserGender::MALE,
        //     type: UserType::EXTERNAL
        // );

        // $user->addTodo(new Todo(
        //     title: 'Sample Todo',
        //     description: 'Nothing to do',
        // ), $schedule1);

        // $entityManager->persist($user);
        // $entityManager->flush();

        // $result = $entityManager->createQueryBuilder()
        //         ->select(sprintf(
        //             'NEW %s(t.title, t.description, ts.date, ts.time)',
        //             \App\DTO\TodoSchedule::class
        //         ))
        //         ->from(Todo::class, 't')
        //         ->leftJoin('t.schedules', 'ts')
        //         ->where('t.id = 1')
        //         ->getQuery()
        //         ->getResult();

        // $result = $entityManager->createQueryBuilder()
        //         ->select(sprintf(
        //             'NEW %s(t.title, t.description, s.date, s.time)',
        //             \App\DTO\TodoSchedule::class
        //         ))
        //         ->from(Schedule::class, 's')
        //         ->leftJoin('s.todos', 't')
        //         ->where('s.id = 1')
        //         ->getQuery()
        //         ->getResult();
        // dd($result);
    }

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
     * @param int      $userId
     * @param int|null scheduleId
     * 
     */
    public function createUserTodo(int $userId): JsonResponse
    {
        /** @var User $user */
        $user         = $this->entityManager->find(User::class, $userId);
        $scheduleId   = Request::get('schedule_id');

        if ($scheduleId !== null) {
            /** @var Schedule $schedule */
            $schedule = $this->entityManager->find(Schedule::class, $scheduleId);
        }

        $user->addTodo(new Todo(
            title: Request::get('title'),
            description: Request::get('description')
        ), $schedule);

        $this->entityManager->persist($user);
        $this->entityManager->flush();
        
        return Response::json($user->todos->toArray());
    }

    public function sampleDqlWithDto(): JsonResponse
    {
        $result = $this->entityManager
                    ->createQueryBuilder()
                    ->select(sprintf(
                        'NEW %s(t.title, t.description, ts.date, ts.time)',
                        \App\DTO\TodoSchedule::class
                    ))
                    ->from(Todo::class, 't')
                    ->leftJoin('t.schedules', 'ts')
                    ->where('t.id = 1')
                    ->getQuery()
                    ->getResult();
        
        return Response::json($result);
    }

    public function sampleRepository(): JsonResponse
    {
        return Response::json(
            $this->entityManager->getRepository(User::class)->getMaleUsers()
        );
    }
}