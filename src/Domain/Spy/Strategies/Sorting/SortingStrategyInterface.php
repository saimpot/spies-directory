<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Strategies\Sorting;

use Illuminate\Database\Eloquent\Builder;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

interface SortingStrategyInterface
{
    public function apply(Builder $query, SortingCriteria $criteria): Builder;
}
