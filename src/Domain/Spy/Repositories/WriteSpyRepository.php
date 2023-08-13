<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Support\Carbon;
use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Prosperty\Core\Domain\Spy\ValueObjects\Country;

class WriteSpyRepository implements WriteSpyRepositoryInterface
{
    public function create(
        string $name,
        string $surname,
        ?Agency $agency,
        Country $countryOfOperation,
        Carbon $birthDate,
        Carbon $deathDate
    ): Spy {
        return Spy::query()->create([
            'name'                 => $name,
            'surname'              => $surname,
            'agency'               => $agency?->toNative(),
            'country_of_operation' => $countryOfOperation->toNative(),
            'birth_date'           => $birthDate,
            'death_date'           => $deathDate,
        ]);
    }
}
