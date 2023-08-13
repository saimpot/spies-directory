<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Providers;

use Illuminate\Support\ServiceProvider;
use Prosperty\Core\Domain\Spy\Rules\AgencyListProviderInterface;
use Prosperty\Core\Domain\Spy\Rules\InMemoryAgencyListProvider;

class SpyServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            AgencyListProviderInterface::class,
            InMemoryAgencyListProvider::class,
        );
    }
}
