<?php

declare(strict_types = 1);

namespace App\Entities;

use App\DTO\Money;
use App\Entities\Types\MoneyType;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Employee extends Person
{
    #[ORM\Column(type: Types::BOOLEAN)]
    public bool $accessCard;

    #[ORM\Column(type: MoneyType::MONEY)]
    public Money $money;
}