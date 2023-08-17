<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Filtering;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\Age;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

class AgeFilteringStrategy implements FilteringStrategyInterface
{
    public function apply(Builder $query, FilteringCriteria $criteria): Builder
    {
        return Age::isExactAge($criteria->getFilters()[Spy::COLUMN_AGE])
            ? $this->filterExactAge($query, $criteria)
            : $this->filterAgeRange($query, $criteria);
    }

    private function filterExactAge(Builder $query, FilteringCriteria $criteria): Builder
    {
        return $query->exactAge((int) $criteria->getFilters()[Spy::COLUMN_AGE]);
    }

    private function filterAgeRange(Builder $query, FilteringCriteria $criteria): Builder
    {
        [$minAge, $maxAge] = explode('-', $criteria->getFilters()[Spy::COLUMN_AGE]);

        return $query->ageRange($minAge, $maxAge);
    }
}
