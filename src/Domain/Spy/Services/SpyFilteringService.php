<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Services;

use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\Enums\FilteringStrategies;
use Prosperty\Core\Domain\Spy\Strategies\Filtering\FilteringStrategyInterface;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

class SpyFilteringService
{
    public function filter(Builder $query, FilteringCriteria $criteria): Builder
    {
        foreach ($criteria->getFilters() as $filter => $value) {
            if ($value === null) {
                continue;
            }

            /* @var FilteringStrategyInterface $strategy */
            $strategy = new (FilteringStrategies::fromString($filter)->value)();
            $query = $strategy->apply($query, $criteria);
        }

        return $query;
    }
}
