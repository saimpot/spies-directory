<?php

declare(strict_types = 1);

namespace Tests\Unit\Http\Controllers;

use App\Http\Controllers\Api\Spy\SpyCollectionController;
use App\Models\Spy;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Mockery;
use Prosperty\Core\Domain\Spy\Resources\SpyCollection;
use Prosperty\Core\Domain\Spy\Services\ReadSpyService;
use Tests\TestCase;

class SpyCollectionControllerTest extends TestCase
{
    use WithFaker;

    protected function tearDown(): void
    {
        Mockery::close();
    }

    public function testRandomMethod(): void
    {
        $readSpyService = Mockery::mock(ReadSpyService::class);
        $spies = Spy::factory(5)->create();
        $readSpyService->shouldReceive('getRandomSpies')->andReturn($spies);

        $controller = new SpyCollectionController($readSpyService);

        $result = $controller->random();

        $this->assertInstanceOf(SpyCollection::class, $result);
        $this->assertSame($spies->toArray(), Arr::except(json_decode($result->toJson(), true), ['count'])['spies']);
    }
}
