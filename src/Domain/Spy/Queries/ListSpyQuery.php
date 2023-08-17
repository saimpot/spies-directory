<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Prosperty\Core\Common\Bus\Query;
use Prosperty\Core\Domain\Spy\ValueObjects\FilteringCriteria;
use Prosperty\Core\Domain\Spy\ValueObjects\SortingCriteria;

class ListSpyQuery extends Query
{
    public const PER_PAGE = 50;

    public function __construct(
        public SortingCriteria $sortingCriteria,
        public FilteringCriteria $filteringCriteria,
        public readonly int $perPage = self::PER_PAGE,
    ) {
    }
}
