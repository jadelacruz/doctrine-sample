<?php

declare(strict_types = 1);

namespace App\Entities;

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
    #[Column]
    #[GeneratedValue()]
    private int $id;

    public function __construct(
        #[Column(length: 25)]
        private string $title,

        #[Column(length: 255)]
        private string $description,
       
        #[Column]
        private \DateTime $schedule,

        #[ManyToOne(inversedBy: 'todos')]
        #[JoinColumn(
            name: 'user_id',
            referencedColumnName: 'id'
        )]
        private User|null $user = null,

        #[Column(options: [ 'default' => 'CURRENT_TIMESTAMP' ])]
        private \DateTime|null $createdAt = new \DateTime(),

        #[Column(columnDefinition: ' DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP')]
        private \DateTime|null $updatedAt = null,

        #[Column(nullable: true)]
        private \DateTime|null $deletedAt = null

    ) {

    }

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description): self
    {
        $this->description = $description;

        return $this;
    }
      
    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getSchedule()
    {
        return $this->schedule;
    }

    public function setSchedule($schedule)
    {
        $this->schedule = $schedule;

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