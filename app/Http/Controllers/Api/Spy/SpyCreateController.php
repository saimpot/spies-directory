<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Spy;

use App\Http\Controllers\Api\ApiController;
use Prosperty\Core\Common\Bus\CommandBus;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommand;
use Prosperty\Core\Domain\Spy\Requests\SpyCreateRequest;
use Prosperty\Core\Domain\Spy\Resources\SpyResource;

class SpyCreateController extends ApiController
{
    public function __construct(
        protected CommandBus $bus
    ) {
    }

    public function __invoke(SpyCreateRequest $request): SpyResource
    {
        return new SpyResource(
            $this->bus->dispatch(
                new CreateSpyCommand(
                    ...$request->validated()
                )
            )
        );
    }
}
