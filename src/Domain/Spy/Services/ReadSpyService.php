<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Services;

use Illuminate\Http\Request;
use Prosperty\Core\Common\Bus\QueryBus;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQuery;
use Prosperty\Core\Domain\Spy\Queries\ListSpyRandomQuery;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class ReadSpyService
{
    public function __construct(
        protected QueryBus $queryBus
    ) {
    }

    public function getRandomSpies()
    {
        return $this->queryBus->ask(new ListSpyRandomQuery());
    }

    public function getAllSpies(Request $request)
    {
        return $this->queryBus->ask(
            new ListSpyQuery(
                new SortingCriteria($request),
                new FilteringCriteria($request)
            )
        );
    }
}
