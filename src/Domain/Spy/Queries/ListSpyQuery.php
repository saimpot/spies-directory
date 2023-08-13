<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Prosperty\Core\Common\Bus\Query;

class ListSpyQuery extends Query
{
    public const PER_PAGE = 50;

    public function __construct(
        public readonly int $perPage = self::PER_PAGE
    ) {
    }
}
