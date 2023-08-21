<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Filtering;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

class CountryFilteringStrategy implements FilteringStrategyInterface
{
    public function apply(Builder $query, FilteringCriteria $criteria): Builder
    {
        return $query->where(Spy::COLUMN_COUNTRY_OF_OPERATION, '=', $criteria->getFilters()[Spy::COLUMN_COUNTRY_OF_OPERATION]);
    }
}
