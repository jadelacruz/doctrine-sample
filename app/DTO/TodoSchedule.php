<?php

declare(strict_types = 1);

namespace App\DTO;

/**
 * @property-read string $title
 * @property-read string $description
 * @property-read \DateTime $date
 * @property-read \DateTime $time
 */
class TodoSchedule
{
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly \DateTime $date,
        public readonly \DateTime $time,
    ) { }
}