<?php

declare(strict_types = 1);

namespace App\Entities;

use Carbon\Carbon;
use App\Constants\AppConstant;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;

#[Entity]
#[Table(name: 'todo')]
class Todo
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    public function __construct(

        #[Column(length: 25)]
        public string $title,

        #[Column(length: 255)]
        public string $description,
       
        #[Column]
        public \DateTime $schedule,

        #[ManyToOne(targetEntity: User::class, inversedBy: 'todos')]
        #[JoinColumn(
            name: 'user_id', 
            nullable: false,
            referencedColumnName: 'id'
        )]
        public User|null $user = null,

        #[Column(options: [ 'default' => 'CURRENT_TIMESTAMP' ])]
        private \DateTime|null $createdAt = new \DateTime(),

        #[Column(columnDefinition: 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP')]
        private \DateTime|null $updatedAt = null,

        #[Column(nullable: true)]
        private \DateTime|null $deletedAt = null

    ) { }
    
    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->createdAt)
                ->format($format);
    }

    public function getUpdatedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->updatedAt)
                ->format($format);
    }

    public function getDeletedAt(string $format = AppConstant::DATE_FORMAT): string
    {
        return Carbon::parse($this->createdAt)
                ->format($format);
    }
}