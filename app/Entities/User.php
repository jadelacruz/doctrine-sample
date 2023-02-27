<?php

declare(strict_types = 1);

namespace App\Entities;

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
    #[Column]
    #[GeneratedValue]
    private int $id;

    public function __construct(

        #[Column(length: 30)]
        private string $name,

        #[Column(
            type: Types::STRING,
            length: 1,
            enumType: UserGender::class
        )]
        private UserGender $gender,

        #[OneToMany(
            targetEntity: Todo::class,
            mappedBy: 'user',
            cascade: ['persist', 'remove']
        )]
        private Collection|null $todos = null,

        #[Column(options: [ 'default' => 'CURRENT_TIMESTAMP' ])]
        private \DateTime|null $createdAt = new \DateTime(),

        #[Column(columnDefinition: 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP')]
        private \DateTime|null $updatedAt = null,

        #[Column(nullable: true)]
        private \DateTime|null $deletedAt = null

    ) {
        $this->todos = new ArrayCollection();
    }

    public function addTodo(Todo $todo): self
    {
        $todo->setUser($this);
        $this->todos->add($todo);

        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getGender()
    {
        return $this->gender;
    }

    public function setGender($gender): self
    {
        $this->gender = $gender;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    public function getDeletedAt()
    {
        return $this->deletedAt;
    }
}