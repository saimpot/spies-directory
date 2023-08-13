<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Rules;

use Prosperty\Core\Domain\Spy\Enums\Agencies;

class InMemoryAgencyListProvider implements AgencyListProviderInterface
{
    public function isKnownAgency(string $agency): bool
    {
        return in_array($agency, array_column(Agencies::cases(), 'value'), true);
    }
}
