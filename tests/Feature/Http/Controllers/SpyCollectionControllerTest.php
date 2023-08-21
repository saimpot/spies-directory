<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Spy;
use Illuminate\Http\Response;
use Illuminate\Testing\TestResponse;
use Prosperty\Core\Domain\Spy\Enums\Permission;
use Prosperty\Core\Domain\Spy\Queries\ListSpyQuery;
use Tests\Feature\FeatureTestCase;

class SpyCollectionControllerTest extends FeatureTestCase
{
    // @TODO: DRY this up

    protected array $factory;

    public function setUp(): void
    {
        parent::setUp();

        $this->factory = $this->userFactory->createApiUser(Permission::RETRIEVE);
    }

    public function testIndexReturnsListOfSpies(): void
    {
        Spy::factory()->count(10)->create();

        $response = $this->getJsonWithToken('/api/spy');

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount(10, 'data.spies')
            ->assertJsonStructure($this->getValidJsonStructure());
    }

    /**
     * @dataProvider paginationDataProvider
     */
    public function testCursorPaginationWorksCorrectly(int $spiesCount, ?string $nextCursorExpectation, int $expectedSpiesOnPage, int $pageToTest): void
    {
        $response = null;

        Spy::factory()->count($spiesCount)->create();

        $currentCursor = '/api/spy';

        for ($i = 0; $i < $pageToTest; $i++) {
            $response = $this->getJsonWithToken($currentCursor);
            $currentCursor = $response->json('links.next');
        }

        if ($nextCursorExpectation === 'absent') {
            $this->assertNull($currentCursor, 'Expected no next cursor but got one.');
        } else {
            $this->assertNotNull($currentCursor, 'Expected a next cursor but got none.');
        }

        $response->assertStatus(Response::HTTP_OK)
            ->assertJsonCount($expectedSpiesOnPage, 'data.spies')
            ->assertJsonStructure($this->getValidJsonStructure());
    }

    public function testSortByBirthDate(): void
    {
        Spy::factory()->create(['birth_date' => '2000-01-01']);
        Spy::factory()->create(['birth_date' => '1990-01-01']);
        Spy::factory()->create(['birth_date' => '2005-01-01']);

        $response = $this->getJsonWithToken('/api/spy?sort=birth_date');

        $spies = $response->json('data.spies');
        $this->assertEquals('1990-01-01', $spies[0]['birth_date']);
        $this->assertEquals('2000-01-01', $spies[1]['birth_date']);
        $this->assertEquals('2005-01-01', $spies[2]['birth_date']);
    }

    public function testSortByFullName(): void
    {
        Spy::factory()->create(['name' => 'John', 'surname' => 'Doe']);
        Spy::factory()->create(['name' => 'Alice', 'surname' => 'Cooper']);
        Spy::factory()->create(['name' => 'Zane', 'surname' => 'Smith']);

        $response = $this->getJsonWithToken('/api/spy?sort=full_name');

        $spies = $response->json('data.spies');
        $this->assertEquals('Cooper, Alice Cooper', $spies[0]['full_name']);
        $this->assertEquals('Doe, John Doe', $spies[1]['full_name']);
        $this->assertEquals('Smith, Zane Smith', $spies[2]['full_name']);
    }

    public function testSortByMultipleCriteria(): void
    {
        Spy::factory()->create(['birth_date' => '1990-01-01', 'name' => 'John', 'surname' => 'Smith']);
        Spy::factory()->create(['birth_date' => '1990-01-01', 'name' => 'Alice', 'surname' => 'Brown']);
        Spy::factory()->create(['birth_date' => '2000-01-01', 'name' => 'Zane', 'surname' => 'White']);

        $response = $this->getJsonWithToken('/api/spy?sort=birth_date,full_name');

        $spies = $response->json('data.spies');
        $this->assertEquals('Brown, Alice Brown', $spies[0]['full_name']);
        $this->assertEquals('Smith, John Smith', $spies[1]['full_name']);
        $this->assertEquals('White, Zane White', $spies[2]['full_name']);
    }

    public function testFilterByAge(): void
    {
        Spy::factory()->create(['birth_date' => '2000-01-01', 'death_date' => now()]);
        Spy::factory()->create(['birth_date' => '1990-01-01', 'death_date' => now()]);
        Spy::factory()->create(['birth_date' => '2005-01-01', 'death_date' => now()]);

        $response = $this->getJsonWithToken('/api/spy?age=23');
        $spies = $response->json('data.spies');
        $this->assertCount(1, $spies);
        $this->assertEquals('2000-01-01', $spies[0]['birth_date']);
    }

    public function testFilterByCountry(): void
    {
        Spy::factory()->create([Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create([Spy::COLUMN_COUNTRY_OF_OPERATION => 'UK']);
        Spy::factory()->create([Spy::COLUMN_COUNTRY_OF_OPERATION => 'CA']);

        $response = $this->getJsonWithToken(sprintf('/api/spy?%s=US', Spy::COLUMN_COUNTRY_OF_OPERATION));

        $spies = $response->json('data.spies');
        $this->assertCount(1, $spies);
        $this->assertEquals('US', $spies[0][Spy::COLUMN_COUNTRY_OF_OPERATION]);
    }

    public function testFilterByMultipleCriteria(): void
    {
        // Age: 23, Country: US
        Spy::factory()->create([
            'birth_date'                     => '2000-01-01',
            'death_date'                     => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'US',
        ]);

        // Age: 33, Country: UK
        Spy::factory()->create([
            'birth_date'                     => '1990-01-01',
            'death_date'                     => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'UK',
        ]);

        // Age: 18, Country: US
        Spy::factory()->create([
            'birth_date'                     => '2005-01-01',
            'death_date'                     => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'US',
        ]);

        $response = $this->getJsonWithToken(sprintf('/api/spy?age=23&%s=US', Spy::COLUMN_COUNTRY_OF_OPERATION));

        $spies = $response->json('data.spies');
        $this->assertCount(1, $spies);
        $this->assertEquals('2000-01-01', $spies[0]['birth_date']);
        $this->assertEquals('US', $spies[0][Spy::COLUMN_COUNTRY_OF_OPERATION]);
    }

    public function testSortByBirthDateAndFilterByCountryAscending(): void
    {
        Spy::factory()->create(['birth_date' => '2000-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create(['birth_date' => '1990-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create(['birth_date' => '2005-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'CA']);

        $response = $this->getJsonWithToken('/api/spy?sort=birth_date&country_of_operation=US');

        $spies = $response->json('data.spies');
        $this->assertCount(2, $spies);
        $this->assertEquals('1990-01-01', $spies[0]['birth_date']);
    }

    public function testSortByBirthDateAndFilterByCountryDescending(): void
    {
        Spy::factory()->create(['birth_date' => '2000-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create(['birth_date' => '1990-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create(['birth_date' => '2005-01-01', Spy::COLUMN_COUNTRY_OF_OPERATION => 'CA']);

        $response = $this->getJsonWithToken('/api/spy?sort=birth_date&direction=desc&country_of_operation=US');

        $spies = $response->json('data.spies');
        $this->assertCount(2, $spies);
        $this->assertEquals('2000-01-01', $spies[0]['birth_date']);
    }

    public function testSortByFullNameAndFilterByAge(): void
    {
        Spy::factory()->create(['name' => 'Adam', 'surname' => 'Smith', 'birth_date' => '2000-01-01', 'death_date' => now()]);
        Spy::factory()->create(['name' => 'Brian', 'surname' => 'Adams', 'birth_date' => '1990-01-01', 'death_date' => now()]);
        Spy::factory()->create(['name' => 'Charlie', 'surname' => 'Brown', 'birth_date' => '2005-01-01', 'death_date' => now()]);

        $response = $this->getJsonWithToken('/api/spy?sort=full_name&age=23');

        $spies = $response->json('data.spies');
        $this->assertCount(1, $spies);
        $this->assertEquals('Smith, Adam Smith', $spies[0]['full_name']);
    }

    public function testAllCombined(): void
    {
        Spy::factory()->create(['name'       => 'Adam', 'surname' => 'Smith', 'birth_date' => '2000-01-01', 'death_date' => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);
        Spy::factory()->create(['name'       => 'Brian', 'surname' => 'Adams', 'birth_date' => '1990-01-01', 'death_date' => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'CA']);
        Spy::factory()->create(['name'       => 'Charlie', 'surname' => 'Brown', 'birth_date' => '2005-01-01', 'death_date' => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'US']);

        // Assuming page 1 with 2 results per page
        $response = $this->getJsonWithToken('/api/spy?sort=full_name&age=23&country=US&page=1&perPage=2');

        $spies = $response->json('data.spies');
        $this->assertCount(1, $spies);
        $this->assertEquals('Smith, Adam Smith', $spies[0]['full_name']);
        $this->assertEquals('2000-01-01', $spies[0]['birth_date']);
        $this->assertEquals('US', $spies[0][Spy::COLUMN_COUNTRY_OF_OPERATION]);
    }

    public function testRandomReturnsSpy(): void
    {
        Spy::factory()->create([
            'name'                           => 'Adam',
            'surname'                        => 'Smith',
            'birth_date'                     => '2000-01-01',
            'death_date'                     => now(),
            Spy::COLUMN_COUNTRY_OF_OPERATION => 'US',
        ]);

        $response = $this->getJsonWithToken('/api/spy/random');

        $spy = $response->json('data.spies');
        $this->assertEquals('Smith, Adam Smith', $spy[0]['full_name']);
    }

    public function testRandomThrottleLimit(): void
    {
        for ($i = 0; $i < 155; $i++) {
            $this->getJsonWithToken('/api/spy/random');
        }

        $response = $this->getJsonWithToken('/api/spy/random');
        $response->assertStatus(Response::HTTP_TOO_MANY_REQUESTS);
    }

    public static function paginationDataProvider(): array
    {
        return [
            'second page'                 => [ListSpyQuery::PER_PAGE * 3, 'present', ListSpyQuery::PER_PAGE, 2],
            'third page for redundancy'   => [ListSpyQuery::PER_PAGE * 4, 'present', ListSpyQuery::PER_PAGE, 3],
            'no second page for 50 spies' => [50, 'absent', 50, 1],
        ];
    }

    private function getValidJsonStructure(): array
    {
        return [
            'data' => ['count', 'spies' => []],
            'links',
            'meta',
        ];
    }

    private function getJsonWithToken(string $uri): TestResponse
    {
        return $this->withToken($this->factory['token'])->getJson($uri, ['Accept' => 'application/json', 'Content-Type' => 'application/json']);
    }
}
