<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Illuminate\Http\Request;
use InvalidArgumentException;

class SortingCriteria
{
    protected const SORT_KEY = 'sort';
    protected const DIRECTION_KEY = 'direction';

    protected const DIRECTION_ASC = 'asc';
    protected const DIRECTION_DESC = 'desc';
    protected const DEFAULT_DIRECTION = self::DIRECTION_ASC;

    protected const ACCEPTABLE_DIRECTION = [
        self::DIRECTION_ASC,
        self::DIRECTION_DESC,
    ];

    public function __construct(
        protected Request $request,
    ) {
        if (
            $this->getSortDirection()
            && !in_array(strtolower($this->getSortDirection()), self::ACCEPTABLE_DIRECTION, true)
        ) {
            throw new InvalidArgumentException("Invalid sorting direction: {$this->getSortDirection()}");
        }
    }

    public function getSortBy(): ?string
    {
        return $this->request->input(self::SORT_KEY);
    }

    public function getSortDirection(): ?string
    {
        return $this->request->input(self::DIRECTION_KEY) ?? self::DEFAULT_DIRECTION;
    }
}
