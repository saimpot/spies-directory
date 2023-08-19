<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Repositories;

use App\Models\Spy;
use Illuminate\Support\Carbon;
use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Prosperty\Core\Domain\Spy\ValueObjects\Country;

interface WriteSpyRepositoryInterface
{
    public function create(
        string $name,
        string $surname,
        Agency $agency,
        Country $countryOfOperation,
        Carbon $birthDate,
        Carbon $deathDate = null,
    ): Spy;
}
