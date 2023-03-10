<?php

declare(strict_types = 1);

namespace App\Entities;

use App\Entities\Embed\Timestamp;
use App\Entities\Embed\TimestampTrait;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\Embedded;


/**
 * @property int         $id
 * @property \DateTime   $date
 * @property \DateTime   $time
 * @property ?Collection $todos
 * @property ?Timestamp  $timestamp
 * @method static getId()
 * @method static getCreatedAt()
 * @method static getUpdatedAt()
 * @method static getDeletedAt()
 */
#[Entity]
#[Table(name: 'schedule')]
class Schedule
{
    use TimestampTrait;

    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    public function __construct(

        #[Column(type: Types::DATE_MUTABLE)]
        public \DateTime $date,

        #[Column(type: Types::TIME_MUTABLE)]
        public \DateTime $time,

        #[ManyToMany(targetEntity: Todo::class, mappedBy: 'schedules')]
        public Collection|null $todos = null,

        #[Embedded(class: Timestamp::class, columnPrefix: false)]
        private ?Timestamp $timestamp = null,

    ) { 
        $this->timestamp = new Timestamp();
    }

    public function getId(): int
    {
        return $this->id;
    }
}