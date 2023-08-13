<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Spy;

use App\Http\Controllers\Api\ApiController;
use Prosperty\Core\Common\Bus\QueryBus;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQuery;
use Prosperty\Core\Domain\Spy\Queries\ListSpyRandomQuery;
use Prosperty\Core\Domain\Spy\Resources\SpyCollection;

class SpyCollectionController extends ApiController
{
    public function __construct(
        protected QueryBus $bus
    ) {
    }

    public function random(): SpyCollection
    {
        return new SpyCollection($this->bus->ask(new ListSpyRandomQuery()));
    }

    public function all(): SpyCollection
    {
        return new SpyCollection($this->bus->ask(new ListSpyQuery()));
    }
}
