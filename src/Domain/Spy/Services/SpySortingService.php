<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Services;

use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\Enums\SortingStrategies;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\SortingStrategyInterface;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class SpySortingService
{
    public function sort(Builder $query, SortingCriteria $criteria): Builder
    {
        foreach (explode(',', $criteria->getSortBy()) as $sortBy) {
            /* @var SortingStrategyInterface $strategy */
            $strategy = new (SortingStrategies::fromString($sortBy)->value)();
            $query = $strategy->apply($query, $criteria);
        }

        return $query;
    }
}
