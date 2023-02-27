<?php

declare(strict_types = 1);

namespace App\Repositories;

use App\Enums\UserGender;
use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository
{
    /**
     * @return App\Entities\User[]
     */
    public function getMaleUsers()
    {
        return $this->findBy(['gender' => UserGender::MALE]);
    }

    /**
     * @return App\Entities\User[]
     */
    public function getFemaleUsers()
    {
        return $this->findBy(['gender' => UserGender::FEMALE]);
    }
}