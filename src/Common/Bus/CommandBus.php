<?php

declare(strict_types = 1);

namespace Prosperty\Core\Common\Bus;

interface CommandBus
{
    public function dispatch(Command $command): mixed;

    public function register(array $map): void;
}
