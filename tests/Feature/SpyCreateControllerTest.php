<?php

declare(strict_types = 1);

namespace Feature;

use App\Models\Spy;
use Database\Factories\UserFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class SpyCreateControllerTest extends TestCase
{
    use RefreshDatabase;

    protected UserFactory $userFactory;

    protected function setUp(
    ): void {
        parent::setUp();

        $this->userFactory = new UserFactory();
    }

    /**
     * @dataProvider spyDataProvider
     */
    public function testValidSpyCreation(string $name, string $surname, string $deathDate = null): void
    {
        $factory = $this->userFactory->createSpyCreateUser();

        $spyData = [
            'name'               => $name,
            'surname'            => $surname,
            'agency'             => 'MI6',
            'countryOfOperation' => 'UK',
            'birthDate'          => '1962-01-01',
            'deathDate'          => $deathDate,
        ];

        $response = $this->withToken($factory['token'])->postJson('/api/spy', $spyData);

        $response->assertStatus(Response::HTTP_CREATED);
        $response->assertJsonStructure([
            'data' => [
                Spy::COLUMN_NAME,
                Spy::COLUMN_SURNAME,
                Spy::COLUMN_AGENCY,
                Spy::COLUMN_COUNTRY_OF_OPERATION,
                Spy::COLUMN_BIRTH_DATE,
                Spy::COLUMN_DEATH_DATE,
                Spy::COLUMN_FULL_NAME,
                Spy::COLUMN_AGE,
            ],
        ]);

        $this->assertDatabaseHas('spies', [Spy::COLUMN_NAME => $name, Spy::COLUMN_SURNAME => $surname, Spy::COLUMN_DEATH_DATE => $deathDate]);
        $this->assertDatabaseCount('spies', 1);
    }

    /**
     * Provide data for testValidSpyCreation.
     */
    public static function spyDataProvider(): array
    {
        return [
            'Spy with null death date' => [
                'name'      => 'James',
                'surname'   => 'Bond',
                'deathDate' => null,
            ],
            'Spy with death date' => [
                'name'      => 'Alec',
                'surname'   => 'Trevelyan',
                'deathDate' => '1995-11-17',
            ],
        ];
    }
}
