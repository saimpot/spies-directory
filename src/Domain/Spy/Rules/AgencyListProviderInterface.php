<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Rules;

interface AgencyListProviderInterface
{
    public function isKnownAgency(string $agency): bool;
}
