<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Prosperty\Core\Common\Bus\Query;

class ListSpyRandomQuery extends Query
{
    public const DEFAULT_RANDOM_SPIES_LIMIT = 5;

    public function __construct(
        public readonly int $limit = self::DEFAULT_RANDOM_SPIES_LIMIT
    ) {
    }
}
