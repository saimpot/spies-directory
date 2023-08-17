<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Filtering;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

class NameFilteringStrategy implements FilteringStrategyInterface
{
    public function apply(Builder $query, FilteringCriteria $criteria): Builder
    {
        return $query->where(Spy::COLUMN_NAME, '=', $criteria->getFilters()[Spy::COLUMN_NAME]);
    }
}
