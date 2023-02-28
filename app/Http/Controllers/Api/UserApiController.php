<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api;

use App\Entities\Schedule;
use App\Entities\Todo;
use App\Entities\User;
use App\Enums\UserGender;
use Doctrine\ORM\EntityManager;
use Illuminate\Routing\Controller as BaseController;

class UserApiController extends BaseController
{
    function test(EntityManager $entityManager)
    {
        // $schedule1 = new Schedule(
        //     date: new \DateTime,
        //     time: (new \DateTime)->setTime(6, 0, 0),
        // );
        // $schedule2 = new Schedule(
        //     date: new \DateTime,
        //     time: (new \DateTime)->setTime(7, 0, 0),
        // );
        // $schedule3 = new Schedule(
        //     date: new \DateTime,
        //     time: (new \DateTime)->setTime(8, 0, 0),
        // );
        
        // $entityManager->persist($schedule1);
        // $entityManager->persist($schedule2);
        // $entityManager->persist($schedule3);
        // $entityManager->flush();

        $schedule1 = $entityManager->find(Schedule::class, 1);
        $user      = new User(
            name  : 'Test Name', 
            gender: UserGender::MALE
        );

        $user->addTodo(new Todo(
            title: 'Sample Todo',
            description: 'Nothing to do',
        ), $schedule1);

        $entityManager->persist($user);
        $entityManager->flush();

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
}