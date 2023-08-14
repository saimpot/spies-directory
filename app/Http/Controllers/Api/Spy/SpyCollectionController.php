<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Spy;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Prosperty\Core\Common\Bus\QueryBus;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQuery;
use Prosperty\Core\Domain\Spy\Queries\ListSpyRandomQuery;
use Prosperty\Core\Domain\Spy\Resources\SpyCollection;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

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

    public function all(Request $request): SpyCollection
    {
        return new SpyCollection(
            $this->bus->ask(
                new ListSpyQuery(
                    new SortingCriteria(
                        $request->get('sortBy'),
                        $request->get('sortDirection')
                    )
                )
            )
        );
    }
}
