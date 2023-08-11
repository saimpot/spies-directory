<?php

declare(strict_types = 1);

namespace Prosperty\Core\Common\Bus;

use Illuminate\Contracts\Bus\Dispatcher;

class IlluminateCommandBus implements CommandBus
{
    public function __construct(
        protected Dispatcher $bus
    ) {
    }

    public function dispatch(Command $command): mixed
    {
        return $this->bus->dispatch($command);
    }

    public function register(array $map): void
    {
        $this->bus->map($map);
    }
}
