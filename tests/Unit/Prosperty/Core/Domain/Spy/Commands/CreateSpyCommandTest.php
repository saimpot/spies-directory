<?php

declare(strict_types = 1);

namespace Tests\Unit\Prosperty\Core\Domain\Spy\Commands;

use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommand;
use Tests\TestCase;

class CreateSpyCommandTest extends TestCase
{
    public function testCommandInitialization(): void
    {
        $name = 'James';
        $surname = 'Bond';
        $agency = 'MIS6';
        $countryOfOperation = 'UK';
        $birthDate = '1962-01-01';
        $deathDate = '1995-11-17';

        $command = new CreateSpyCommand(
            name: $name,
            surname: $surname,
            agency: $agency,
            countryOfOperation: $countryOfOperation,
            birthDate: $birthDate,
            deathDate: $deathDate
        );

        $this->assertSame($name, $command->name);
        $this->assertSame($surname, $command->surname);
        $this->assertSame($agency, $command->agency);
        $this->assertSame($countryOfOperation, $command->countryOfOperation);
        $this->assertSame($birthDate, $command->birthDate);
        $this->assertSame($deathDate, $command->deathDate);
    }
}
