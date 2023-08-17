<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Spy;

use App\Http\Controllers\Api\ApiController;
use Prosperty\Core\Domain\Spy\Requests\SpyCreateRequest;
use Prosperty\Core\Domain\Spy\Resources\SpyResource;
use Prosperty\Core\Domain\Spy\Services\WriteSpyService;

class SpyCreateController extends ApiController
{
    public function __construct(
        protected WriteSpyService $writeSpyService,
    ) {
    }

    public function __invoke(SpyCreateRequest $request): SpyResource
    {
        return new SpyResource($this->writeSpyService->createSpy($request));
    }
}
