<?php

declare(strict_types = 1);

namespace Prosperty\Core\Common\Providers;

use Carbon\Laravel\ServiceProvider;
use Prosperty\Core\Common\Bus\CommandBus;
use Prosperty\Core\Common\Bus\IlluminateCommandBus;
use Prosperty\Core\Common\Bus\IlluminateQueryBus;
use Prosperty\Core\Common\Bus\QueryBus;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommand;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommandHandler;
use Prosperty\Core\Domain\Spy\Queries\FindSpyQuery;
use Prosperty\Core\Domain\Spy\Queries\FindSpyQueryHandler;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQuery;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQueryHandler;
use Prosperty\Core\Domain\Spy\Queries\ListSpyRandomQuery;
use Prosperty\Core\Domain\Spy\Queries\ListSpyRandomQueryHandler;
use Prosperty\Core\Domain\Spy\Repositories\ReadSpyRepository;
use Prosperty\Core\Domain\Spy\Repositories\ReadSpyRepositoryInterface;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepository;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepositoryInterface;

class CommonServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $singletons = [
            CommandBus::class                  => IlluminateCommandBus::class,
            QueryBus::class                    => IlluminateQueryBus::class,
            WriteSpyRepositoryInterface::class => WriteSpyRepository::class,
            ReadSpyRepositoryInterface::class  => ReadSpyRepository::class,
        ];

        foreach ($singletons as $abstract => $concrete) {
            $this->app->singleton($abstract, $concrete);
        }
    }

    public function boot(): void
    {
        $commandHandlers = [
            CreateSpyCommand::class => CreateSpyCommandHandler::class,
        ];

        $commandBus = app(CommandBus::class);

        foreach ($commandHandlers as $command => $handler) {
            $commandBus->register([$command => $handler]);
        }

        $queryHandlers = [
            FindSpyQuery::class       => FindSpyQueryHandler::class,
            ListSpyRandomQuery::class => ListSpyRandomQueryHandler::class,
            ListSpyQuery::class       => ListSpyQueryHandler::class,
        ];

        $queryBus = app(QueryBus::class);

        foreach ($queryHandlers as $query => $handler) {
            $queryBus->register([$query => $handler]);
        }
    }
}
