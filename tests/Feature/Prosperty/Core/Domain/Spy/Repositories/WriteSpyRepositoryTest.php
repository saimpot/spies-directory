<?php

declare(strict_types = 1);

namespace Tests\Feature\Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepository;
use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Prosperty\Core\Domain\Spy\ValueObjects\Country;
use Tests\TestCase;

class WriteSpyRepositoryTest extends TestCase
{
    use RefreshDatabase;

    public function testCreateStoresSpyInDatabase(): void
    {
        $repository = new WriteSpyRepository();

        $name = 'James';
        $surname = 'Bond';
        $agency = Agency::fromString('MI6');
        $country = Country::fromString('UK');
        $birthDate = Carbon::parse('1962-01-01');
        $deathDate = Carbon::parse('1995-11-17');

        $repository->create($name, $surname, $agency, $country, $birthDate, $deathDate);

        $this->assertDatabaseHas('spies', [
            'name'                 => $name,
            'surname'              => $surname,
            'agency'               => $agency->toNative(),
            'country_of_operation' => $country->toNative(),
            'birth_date'           => $birthDate->toDateString(),
            'death_date'           => $deathDate->toDateString(),
        ]);

        $this->assertDatabaseCount(Spy::TABLE_NAME, 1);
    }
}
