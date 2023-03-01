<?php

declare(strict_types = 1);

namespace App\Entities;

use App\Enums\UserGender;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\InheritanceType;

#[Entity]
#[InheritanceType('JOINED')]
#[DiscriminatorColumn(name: 'discr', type: 'string')]
#[DiscriminatorMap(['person' => Person::class, 'employee' => Employee::class])]
class Person
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    #[Column(length: 30)]
    public string $name;

    #[Column(
        type: Types::STRING,
        length: 1,
        enumType: UserGender::class
    )]
    public UserGender $gender;
}