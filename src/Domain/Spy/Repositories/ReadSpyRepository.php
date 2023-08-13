<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;

class ReadSpyRepository implements ReadSpyRepositoryInterface
{
    public function fetchRandomSpies(int $limit): Collection
    {
        return Spy::query()->inRandomOrder()->limit($limit)->get();
    }

    public function fetchAllSpies(int $perPage): CursorPaginator
    {
        return Spy::query()->cursorPaginate($perPage);
    }
}
