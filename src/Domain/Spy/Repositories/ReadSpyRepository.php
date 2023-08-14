<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Prosperty\Core\Domain\Spy\Enums\SortingStrategies;
use Prosperty\Core\Domain\Spy\Strategies\SortingStrategyInterface;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class ReadSpyRepository implements ReadSpyRepositoryInterface
{
    public function fetchRandomSpies(int $limit): Collection
    {
        return Spy::query()->inRandomOrder()->limit($limit)->get();
    }

    public function fetchAllSpies(SortingCriteria $sortingCriteria, int $perPage): CursorPaginator
    {
        $query = Spy::query();

        if ($sortingCriteria->getSortBy() !== null) {
            $query = $this->applySortingStrategy($query, $sortingCriteria);
        }

        return $query->cursorPaginate($perPage);
    }

    private function applySortingStrategy(Builder $query, SortingCriteria $sortingCriteria): Builder
    {
        foreach (explode(',', $sortingCriteria->getSortBy()) as $sortBy) {
            if ($sortBy === null) {
                continue;
            }

            /* @var SortingStrategyInterface $strategy */
            $strategy = new (SortingStrategies::fromString($sortBy)->value)();
            $query = $strategy->apply($query, $sortingCriteria);
        }

        return $query;
    }
}
