<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\CursorPaginator;
use Prosperty\Core\Domain\Spy\Services\SpyFilteringService;
use Prosperty\Core\Domain\Spy\Services\SpySortingService;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class ReadSpyRepository implements ReadSpyRepositoryInterface
{
    public function __construct(
        protected SpyFilteringService $spyFilteringService,
        protected SpySortingService $spySortingService,
    ) {
    }

    public function fetchRandomSpies(int $limit): Collection
    {
        return Spy::query()->inRandomOrder()->limit($limit)->get();
    }

    public function fetchAllSpies(SortingCriteria $sortingCriteria, FilteringCriteria $filteringCriteria, int $perPage): CursorPaginator
    {
        $query = Spy::query();

        if (!empty($filteringCriteria->getFilters())) {
            $query = $this->spyFilteringService->filter($query, $filteringCriteria);
        }

        if ($sortingCriteria->getSortBy() !== null) {
            $query = $this->spySortingService->sort($query, $sortingCriteria);
        }

        return $query->cursorPaginate($perPage);
    }
}
