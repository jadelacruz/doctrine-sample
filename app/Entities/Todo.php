<?php

declare(strict_types = 1);

namespace App\Entities;

use Carbon\Carbon;
use App\Constants\AppConstant;
use App\Entities\Embed\TimestampTrait;
use Carbon\Traits\Timestamp;
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
       
        #[ManyToMany(targetEntity: Schedule::class, inversedBy: 'todos', cascade: ['persist', 'remove'])]
        #[JoinTable(name: 'todos_schedules')]
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


    ) { }
    
    public function getId(): int
    {
        return $this->id;
    }
}