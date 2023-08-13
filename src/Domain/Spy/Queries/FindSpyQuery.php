<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use Prosperty\Core\Common\Bus\Query;

class FindSpyQuery extends Query
{
    public function __construct(
        public readonly int $id
    ) {
    }
}
