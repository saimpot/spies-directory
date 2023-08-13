<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Illuminate\Support\Collection;
use Prosperty\Core\Common\Bus\QueryHandler;
use Prosperty\Core\Domain\Spy\Repositories\ReadSpyRepositoryInterface;

class ListSpyRandomQueryHandler extends QueryHandler
{
    public function __construct(
        protected readonly ReadSpyRepositoryInterface $repository
    ) {
    }

    public function handle(ListSpyRandomQuery $query): Collection
    {
        return $this->repository->fetchRandomSpies($query->limit);
    }
}
