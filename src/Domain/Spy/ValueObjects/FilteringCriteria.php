<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Prosperty\Core\Domain\Spy\Enums\FilteringStrategies;
use Prosperty\Core\Domain\Spy\Requests\SpyFilterRequest;

class FilteringCriteria
{
    public function __construct(
        protected Request $request,
    ) {
        Validator::make($this->getFilters(), app(SpyFilterRequest::class)->rules())->validate();
    }

    public function getFilters(): array
    {
        return $this->request->only(FilteringStrategies::columns());
    }
}
