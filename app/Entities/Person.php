<?php

declare(strict_types = 1);

namespace App\Entities;

use App\Enums\UserGender;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\MappedSuperclass;

#[MappedSuperclass]
class Person
{
    #[Column(length: 30)]
    protected string $name;

    #[Column(
        type: Types::STRING,
        length: 1,
        enumType: UserGender::class
    )]
    protected UserGender $gender;
}