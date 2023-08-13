<?php

namespace Prosperty\Core\Domain\Spy\Resources;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class SpyCollection extends ResourceCollection
{
    public function toArray(Request $request): array
    {
        return [
            'count' => $this->collection->count(),
            'spies' => $this->collection,
        ];
    }

    public function withResponse(Request $request, JsonResponse $response): void
    {
        $headers = [
            'X-RateLimit-Limit'     => $response->headers->get('X-RateLimit-Limit'),
            'X-RateLimit-Remaining' => $response->headers->get('X-RateLimit-Remaining'),
            'X-RateLimit-Reset'     => $response->headers->get('X-RateLimit-Reset'),
        ];

        $response->withHeaders($headers);
    }
}
