<?php

declare(strict_types = 1);

namespace App\Entities;

use App\Enums\UserType;
use App\Enums\UserGender;
use App\Entities\Embed\Timestamp;
use App\Entities\Embed\TimestampTrait;
use App\Repositories\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\GeneratedValue;
use Doctrine\ORM\Mapping\Id;
use Doctrine\ORM\Mapping\Table;
use Doctrine\ORM\Mapping\OneToMany;
use Doctrine\ORM\Mapping\Embedded;
use Doctrine\DBAL\Types\Types;


/**
 * @property int         $id
 * @property string      $name
 * @property UserGender  $gender
 * @property UserType    $type
 * @property ?Collection $todos
 * @property ?Timestamp  $timestamp
 * @method static getId()
 * @method static getCreatedAt()
 * @method static getUpdatedAt()
 * @method static getDeletedAt()
 * @method static addTodo()
 */
#[Entity(UserRepository::class)]
#[Table(name: 'user')]
class User
{
    use TimestampTrait;

    #[Id]
    #[Column(type: Types::GUID)]
    #[GeneratedValue(strategy: 'UUID')]
    private string $id;

    public function __construct(

        #[Column(length: 30, unique: true)]
        public string $name,
    
        #[Column(
            type: Types::STRING,
            length: 1,
            enumType: UserGender::class
        )]

        public UserGender $gender,
        
        #[Column(
            type: Types::STRING,
            length: 8,
            enumType: UserType::class
        )]
        public UserType $type,

        #[OneToMany(
            targetEntity: Todo::class,
            mappedBy: 'user',
            cascade: ['persist', 'remove']
        )]
        public ?Collection $todos = null,

        #[Embedded(class: Timestamp::class, columnPrefix: false)]
        private ?Timestamp $timestamp = null,

    ) {
        $this->todos     = new ArrayCollection();
        $this->timestamp = new Timestamp();
    }

    public function getId()
    {
        return $this->id;
    }

    public function addTodo(Todo $todo, ?Schedule $schedule = null): self
    {
        $todo->user = $this;

        if ($schedule !== null) {
            $todo->schedules = new ArrayCollection([$schedule]);
        }

        $this->todos->add($todo);
        return $this;
    }
}