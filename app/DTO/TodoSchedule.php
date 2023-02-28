<?php

declare(strict_types = 1);

namespace App\DTO;

class TodoSchedule
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly \DateTime $date,
        public readonly \DateTime $time,
    ) { }
}