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

        /**
         * @var string
         */
        public readonly string $title,

        /**
         * @var string
         */
        public readonly string $description,

        /**
         * @var \DateTime|null
         */
        public readonly ?\DateTime $date,

        /**
         * @var \DateTime|null
         */
        public readonly ?\DateTime $time,
        
    ) { }
}