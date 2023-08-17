<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use InvalidArgumentException;

class SortingCriteria
{
    protected const DIRECTION_ASC = 'asc';
    protected const DIRECTION_DESC = 'desc';
    protected const DEFAULT_DIRECTION = self::DIRECTION_ASC;
    protected const ACCEPTABLE_DIRECTION = [
        self::DIRECTION_ASC,
        self::DIRECTION_DESC,
    ];

    public function __construct(
        protected ?string $sortBy,
        protected ?string $sortDirection
    ) {
        if (
            $this->sortDirection
            && !in_array(strtolower($this->sortDirection), self::ACCEPTABLE_DIRECTION, true)
        ) {
            throw new InvalidArgumentException("Invalid sorting direction: {$this->sortDirection}");
        }
    }

    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    public function getSortDirection(): ?string
    {
        return $this->sortDirection ?? self::DEFAULT_DIRECTION;
    }
}
