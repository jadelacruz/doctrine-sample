<?php

declare(strict_types = 1);

namespace App\Providers;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Events;
use Illuminate\Support\ServiceProvider;
use App\Events\SampleFlushListener;

class DataMapperServiceProvider extends ServiceProvider
{
    public function register()
    {
        $entityManager = $this->app->get(EntityManager::class);
        $eventManager  = $entityManager->getEventManager();
        $eventManager->addEventListener([Events::onFlush], new SampleFlushListener);
    }

    public function boot()
    {

    }
}