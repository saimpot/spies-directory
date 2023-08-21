<?php

declare(strict_types = 1);

namespace Tests\Feature\Http\Controllers;

use App\Models\Spy;
use Illuminate\Support\Arr;
use Prosperty\Core\Domain\Spy\Enums\Permission;
use Symfony\Component\HttpFoundation\Response;
use Tests\Feature\FeatureTestCase;

class SpyCreateControllerTest extends FeatureTestCase
{
    // @TODO: DRY this up

    /**
     * @dataProvider spyDataProvider
     */
    public function testValidSpyCreationWithVariableDeathDates(string $name, string $surname, string $deathDate = null): void
    {
        $factory = $this->userFactory->createApiUser(Permission::CREATE);

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

        $this->assertDatabaseHas(Spy::TABLE_NAME, [Spy::COLUMN_NAME => $name, Spy::COLUMN_SURNAME => $surname, Spy::COLUMN_DEATH_DATE => $deathDate]);
        $this->assertDatabaseCount(Spy::TABLE_NAME, 1);
    }

    /**
     * @dataProvider invalidSpyDataProvider
     */
    public function testInvalidSpyDataCreation(array $spyData, string $expectedErrorField): void
    {
        $factory = $this->userFactory->createApiUser(Permission::CREATE);
        $response = $this->withToken($factory['token'])->postJson('/api/spy', $spyData);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
        $response->assertJsonValidationErrors($expectedErrorField);

        $this->assertDatabaseCount(Spy::TABLE_NAME, 0);
    }

    public function testUnauthorizedUserCannotCreateSpy(): void
    {
        $response = $this->postJson('/api/spy', []);

        $response->assertStatus(Response::HTTP_UNAUTHORIZED);
        $this->assertDatabaseCount(Spy::TABLE_NAME, 0);
    }

    /**
     * @dataProvider wrongPermissionsDataProvider
     */
    public function testUserWithWrongPermissionsCannotCreateSpy(Permission $permission): void
    {
        $factory = $this->userFactory->createApiUser($permission);
        $response = $this->withToken($factory['token'])->postJson('/api/spy');

        $response->assertStatus(Response::HTTP_FORBIDDEN);
        $this->assertDatabaseCount(Spy::TABLE_NAME, 0);
    }

    public static function wrongPermissionsDataProvider(): array
    {
        return Arr::except([Permission::cases()], [Permission::CREATE]);
    }

    /**
     * Provide data for testInvalidSpyCreation.
     */
    public static function invalidSpyDataProvider(): array
    {
        return [
            'Missing name' => [
                'spyData' => [
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'name',
            ],
            'Missing surname' => [
                'spyData' => [
                    'name'               => 'James',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'surname',
            ],
            'Missing countryOfOperation' => [
                'spyData' => [
                    'name'      => 'James',
                    'surname'   => 'Bond',
                    'agency'    => 'MI6',
                    'birthDate' => '1962-01-01',
                    'deathDate' => null,
                ],
                'expectedErrorField' => 'countryOfOperation',
            ],
            'Missing birthDate' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'birthDate',
            ],
            'Empty name' => [
                'spyData' => [
                    'name'               => null,
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'name',
            ],
            'Empty surname' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => null,
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'surname',
            ],
            'Empty countryOfOperation' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => null,
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'countryOfOperation',
            ],
            'Empty birthDate' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => null,
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'birthDate',
            ],
            'Invalid agency' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'TOTALLY_INVALID_AGENCY',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'agency',
            ],

            'Birth date after death date' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1996-01-01',
                    'deathDate'          => '1995-11-17',
                ],
                'expectedErrorField' => 'deathDate',
            ],

            'Future birth date' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '2100-01-01', // Future date
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'birthDate',
            ],
            'Future death date' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'MI6',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => '2100-11-17',
                ],
                'expectedErrorField' => 'deathDate',
            ],

            'Non-existing agency' => [
                'spyData' => [
                    'name'               => 'James',
                    'surname'            => 'Bond',
                    'agency'             => 'NOT_EXISTING_AGENCY',
                    'countryOfOperation' => 'UK',
                    'birthDate'          => '1962-01-01',
                    'deathDate'          => null,
                ],
                'expectedErrorField' => 'agency',
            ],
        ];
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
