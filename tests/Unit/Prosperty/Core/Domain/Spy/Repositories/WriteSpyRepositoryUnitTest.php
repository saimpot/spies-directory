<?php

declare(strict_types = 1);

namespace Tests\Unit\Prosperty\Core\Domain\Spy\Repositories;

use Illuminate\Support\Carbon;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepository;
use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Prosperty\Core\Domain\Spy\ValueObjects\Country;
use Tests\TestCase;

class WriteSpyRepositoryUnitTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testCreateCallsEloquentMethods(): void
    {
        $spyMock = Mockery::mock('overload:\App\Models\Spy');

        $name = 'James';
        $surname = 'Bond';
        $agency = Agency::fromString('MI6');
        $country = Country::fromString('UK');
        $birthDate = Carbon::parse('1962-01-01');
        $deathDate = Carbon::parse('1995-11-17');

        $spyMock->shouldReceive('query')->once()->andReturnSelf();
        $spyMock->shouldReceive('create')
            ->once()
            ->with([
                'name'                 => $name,
                'surname'              => $surname,
                'agency'               => $agency->toNative(),
                'country_of_operation' => $country->toNative(),
                'birth_date'           => $birthDate,
                'death_date'           => $deathDate,
            ])
            ->andReturnSelf();

        $repository = new WriteSpyRepository();
        $repository->create($name, $surname, $agency, $country, $birthDate, $deathDate);
    }
}
