<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Services;

use App\Models\Spy;
use Prosperty\Core\Common\Bus\CommandBus;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommand;
use Prosperty\Core\Domain\Spy\Requests\SpyCreateRequest;

class WriteSpyService
{
    public function __construct(
        protected CommandBus $commandBus
    ) {
    }

    public function createSpy(SpyCreateRequest $request): Spy
    {
        return $this->commandBus->dispatch(
            new CreateSpyCommand(
                ...$request->validated()
            )
        );
    }
}
