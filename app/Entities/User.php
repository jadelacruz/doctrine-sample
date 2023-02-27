<?php

declare(strict_types = 1);

namespace App\Entities;

use Carbon\Carbon;
use App\Constants\AppConstant;
use App\Enums\UserGender;
use App\Repositories\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\DBAL\Types\Types;


#[Entity(UserRepository::class)]
#[Table(name: 'user')]
class User
{
    #[Id]
    #[Column, GeneratedValue]
    private int $id;

    public function __construct(

        #[Column(length: 30)]
        public string $name,

        #[Column(
            type: Types::STRING,
            length: 1,
            enumType: UserGender::class
        )]
        public UserGender $gender,

        #[OneToMany(
            targetEntity: Todo::class,
            mappedBy: 'user',
            cascade: ['persist', 'remove']
        )]
        public Collection|null $todos = null,

        #[Column(options: ['default' => 'CURRENT_TIMESTAMP'])]
        private \DateTime|null $createdAt = new \DateTime(),

        #[Column(columnDefinition: 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP')]
        private \DateTime|null $updatedAt = null,
    
        #[Column(nullable: true)]
        private \DateTime|null $deletedAt = null

    ) {
        $this->todos = new ArrayCollection();
    }

    public function getId()
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

    public function addTodo(Todo $todo): self
    {
        $todo->user = $this;
        $this->todos->add($todo);

        return $this;
    }
}