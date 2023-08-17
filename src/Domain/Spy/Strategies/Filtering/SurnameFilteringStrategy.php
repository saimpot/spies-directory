<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Filtering;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

class SurnameFilteringStrategy implements FilteringStrategyInterface
{
    public function apply(Builder $query, FilteringCriteria $criteria): Builder
    {
        return $query->where(Spy::COLUMN_SURNAME, '=', $criteria->getFilters()[Spy::COLUMN_SURNAME]);
    }
}
