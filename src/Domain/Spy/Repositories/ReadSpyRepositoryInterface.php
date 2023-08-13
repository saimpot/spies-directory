<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

interface ReadSpyRepositoryInterface
{
    public function fetchRandomSpies(int $limit): Collection;

    public function fetchAllSpies(int $perPage): CursorPaginator;
}
