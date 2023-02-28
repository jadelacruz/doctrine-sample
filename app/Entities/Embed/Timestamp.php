<?php

namespace App\Entities\Embed;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping\Column;
use Doctrine\ORM\Mapping\Embeddable;

#[Embeddable]
class Timestamp
{
    public function __construct(
        #[Column(type: Types::DATETIME_IMMUTABLE, options: [ 'default' => 'CURRENT_TIMESTAMP' ])]
        public \DateTimeImmutable|null $createdAt = new \DateTimeImmutable(),
    
        #[Column(columnDefinition: 'DATETIME DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP')]
        public \DateTime|null $updatedAt = null,
    
        #[Column(nullable: true)]
        public \DateTime|null $deletedAt = null
    ) { }
}