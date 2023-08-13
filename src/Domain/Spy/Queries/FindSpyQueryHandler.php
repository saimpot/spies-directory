<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Queries;

use App\Models\Spy;
use Prosperty\Core\Common\Bus\QueryHandler;
use Prosperty\Core\Domain\Spy\Repositories\ReadSpyRepositoryInterface;

class FindSpyQueryHandler extends QueryHandler
{
    public function __construct(
        protected readonly ReadSpyRepositoryInterface $repository
    ) {
    }

    public function handle(FindSpyQuery $query): Spy
    {
        return $this->repository->findSpyById($query->id);
    }
}
