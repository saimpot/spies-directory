<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class BirthDateSortingStrategy implements SortingStrategyInterface
{
    public function apply(Builder $query, SortingCriteria $criteria): Builder
    {
        return $query->orderBy(Spy::COLUMN_BIRTH_DATE, $criteria->getSortDirection());
    }
}
