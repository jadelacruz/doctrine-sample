<?php

declare(strict_types = 1);

namespace App\Enums;

enum UserType: string
{
    case INTERNAL = 'internal';
    case EXTERNAL = 'external';

    /**
     * @return string
     */
    public function titleCase(): string
    {
        return ucfirst(strtolower($this->name));
    }
}