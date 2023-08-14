<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Illuminate\Pagination\CursorPaginator;
use Prosperty\Core\Common\Bus\QueryHandler;
use Prosperty\Core\Domain\Spy\Repositories\ReadSpyRepositoryInterface;

class ListSpyQueryHandler extends QueryHandler
{
    public function __construct(
        protected readonly ReadSpyRepositoryInterface $repository
    ) {
    }

    public function handle(ListSpyQuery $query): CursorPaginator
    {
        return $this->repository->fetchAllSpies($query->sortingCriteria, $query->perPage);
    }
}
