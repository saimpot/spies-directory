<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Commands;

use Prosperty\Core\Common\Bus\Command;

class CreateSpyCommand extends Command
{
    public function __construct(
        public readonly string $name,
        public readonly string $surname,
        public readonly ?string $agency,
        public readonly string $countryOfOperation,
        public readonly string $birthDate,
        public readonly ?string $deathDate,
    ) {
    }
}
