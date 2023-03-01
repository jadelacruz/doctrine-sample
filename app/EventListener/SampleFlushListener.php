<?php

declare(strict_types = 1);

namespace App\EventListener;

use App\Entities\User;
use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\OnFlushEventArgs;
use Doctrine\ORM\Events;

class SampleFlushListener implements EventSubscriber
{
    public function getSubscribedEvents(): array
    {
        return [Events::onFlush];
    }

    public function onFlush(OnFlushEventArgs $eventArgs)
    {
        /** @var \LaravelDoctrine\ORM\Facades\EntityManager $entityManager */
        $entityManager = $eventArgs->getObjectManager();
        $unitOfWork    = $entityManager->getUnitOfWork();

        /** @var \App\Entities\User $entity */
        foreach ($unitOfWork->getScheduledEntityUpdates() as $entity) {
            $entity->name = $entity->name . '_e';
            $unitOfWork->computeChangeSet($entityManager->getClassMetadata(User::class), $entity);
        }
    }
}