<?php

declare(strict_types = 1);

namespace App\Http\Controllers\Api\Spy;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Prosperty\Core\Domain\Spy\Resources\SpyCollection;
use Prosperty\Core\Domain\Spy\Services\ReadSpyService;

class SpyCollectionController extends ApiController
{
    public function __construct(
        protected ReadSpyService $readSpyService,
    ) {
    }

    public function random(): SpyCollection
    {
        return new SpyCollection($this->readSpyService->getRandomSpies());
    }

    public function all(Request $request): SpyCollection
    {
        return new SpyCollection($this->readSpyService->getAllSpies($request));
    }
}
