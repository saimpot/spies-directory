<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Illuminate\Http\Request;
use Prosperty\Core\Domain\Spy\Enums\FilteringStrategies;

class FilteringCriteria
{
    public function __construct(
        protected Request $request,
    ) {
    }

    public function getFilters(): array
    {
        return $this->request->only(FilteringStrategies::columns());
    }
}
