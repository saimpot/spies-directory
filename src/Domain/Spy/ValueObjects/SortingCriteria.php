<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use InvalidArgumentException;

class SortingCriteria
{
    protected array $acceptableDirections = ['asc', 'desc'];

    public function __construct(
        protected ?string $sortBy,
        protected ?string $sortDirection
    ) {
        if (
            $this->sortDirection
            && !in_array($this->sortDirection, $this->acceptableDirections, true)
        ) {
            throw new InvalidArgumentException('Invalid sort direction');
        }
    }

    public function getSortBy(): ?string
    {
        return $this->sortBy;
    }

    public function getSortDirection(): ?string
    {
        return $this->sortDirection ?? $this->acceptableDirections[0];
    }
}
