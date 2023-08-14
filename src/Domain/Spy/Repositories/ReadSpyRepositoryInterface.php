<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

interface ReadSpyRepositoryInterface
{
    public function fetchRandomSpies(int $limit): Collection;

    public function fetchAllSpies(
        SortingCriteria $sortingCriteria,
        int $perPage
    ): CursorPaginator;
}
