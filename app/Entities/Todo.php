<?php

declare(strict_types = 1);

namespace App\Entities;

use App\Entities\Embed\TimestampTrait;
use App\Entities\Embed\Timestamp;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\ManyToMany;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping\JoinTable;
use Doctrine\ORM\Mapping\Embedded;


/**
 * @property int         $id
 * @property string      $title
 * @property string      $description
 * @property ?Collection $schedules
 * @property ?User       $user
 * @property ?Timestamp  $timestamp
 * @method static getId()
 * @method static getCreatedAt()
 * @method static getUpdatedAt()
 * @method static getDeletedAt()
 */
#[Entity]
#[Table(name: 'todo')]
class Todo
{
    use TimestampTrait;

    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    public function __construct(

        #[Column(length: 25)]
        public string $title,

        #[Column(length: 255)]
        public string $description,
       
        #[ManyToMany(targetEntity: Schedule::class, inversedBy: 'todos', cascade: ['persist'])]
        #[JoinTable(name: 'todos_schedules')]
        #[JoinColumn(onDelete: 'cascade')]
        public ?Collection $schedules = null,

        #[ManyToOne(targetEntity: User::class, inversedBy: 'todos')]
        #[JoinColumn(
            name: 'user_id', 
            nullable: false,
            referencedColumnName: 'id'
        )]
        public ?User $user = null,

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