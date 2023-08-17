<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Filtering;

use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;

interface FilteringStrategyInterface
{
    public function apply(Builder $query, FilteringCriteria $criteria): Builder;
}
