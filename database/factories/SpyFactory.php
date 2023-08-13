<?php

declare(strict_types = 1);

namespace Database\Factories;

use App\Models\Spy;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Prosperty\Core\Domain\Spy\Enums\Agencies;

class SpyFactory extends Factory
{
    public function definition(): array
    {
        return [
            Spy::COLUMN_NAME                 => fake()->firstName,
            Spy::COLUMN_SURNAME              => fake()->lastName,
            Spy::COLUMN_AGENCY               => Arr::random(array_column(Agencies::cases(), 'value')),
            Spy::COLUMN_COUNTRY_OF_OPERATION => fake()->countryCode,
            Spy::COLUMN_BIRTH_DATE           => fake()->date,
            Spy::COLUMN_DEATH_DATE           => fake()->date,
        ];
    }
}
