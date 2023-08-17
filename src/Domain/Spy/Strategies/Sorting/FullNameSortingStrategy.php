<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Sorting;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class FullNameSortingStrategy implements SortingStrategyInterface
{
    public function apply(Builder $query, SortingCriteria $criteria): Builder
    {
        return $query
            ->orderBy(Spy::COLUMN_SURNAME, $criteria->getSortDirection())
            ->orderBy(Spy::COLUMN_NAME, $criteria->getSortDirection());
    }
}
