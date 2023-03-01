<?php
declare(strict_types = 1);

namespace App\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Doctrine\DBAL\Types\Type;
use Illuminate\Support\ServiceProvider;
use App\Entities\Types\MoneyType;
use App\Events\SampleFlushListener;

class DataMapperServiceProvider extends ServiceProvider
{

    public function register()
    {
        $entityManager = $this->app->get(EntityManager::class);
        $this->bindEventListeners($entityManager);
        $this->bindCustomDataTypes($entityManager);
    }

    public function boot()
    { }
   
    private function bindEventListeners(EntityManager $entityManager)
    {
        $eventManager = $entityManager->getEventManager();
        $eventManager->addEventListener([Events::onFlush], new SampleFlushListener);
    }

    private function bindCustomDataTypes(EntityManager $entityManager)
    {
        Type::addType(MoneyType::MONEY, MoneyType::class);
        $connection = $entityManager->getConnection();
        $connection->getDatabasePlatform()
                   ->registerDoctrineTypeMapping(MoneyType::MONEY, MoneyType::MONEY);
    }
}