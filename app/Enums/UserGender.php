<?php

declare(strict_types = 1);

namespace App\Enums;

enum UserGender: string
{
    case MALE   = 'm';
    case FEMALE = 'f';

    /**
     * @return string
     */
    public function titleCase(): string
    {
        return ucfirst(strtolower($this->name));
    }
}