<?php

declare(strict_types = 1);

namespace App\Entities\Types;

use App\DTO\Money;
use Doctrine\DBAL\Types\Type;
use Doctrine\DBAL\Platforms\AbstractPlatform;

class MoneyType extends Type
{
    const MONEY = 'money';

    public function getName()
    {
        return self::MONEY;
    }

    public function getSqlDeclaration(array $fieldDeclaration, AbstractPlatform $platform)
    {
        return 'DECIMAL(19, 2)';
    }

    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return new Money((float)$value);
    }

    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }
}