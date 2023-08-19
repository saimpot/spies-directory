<?php

declare(strict_types = 1);

namespace Tests\Unit\Prosperty\Core\Domain\Spy\Commands;

use Illuminate\Support\Carbon;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryPHPUnitIntegration;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommand;
use Prosperty\Core\Domain\Spy\Commands\CreateSpyCommandHandler;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepositoryInterface;
use Tests\TestCase;

class CreateSpyCommandHandlerTest extends TestCase
{
    use MockeryPHPUnitIntegration;

    public function testHandleCreatesSpy(): void
    {
        $repository = Mockery::mock(WriteSpyRepositoryInterface::class);

        $name = 'James';
        $surname = 'Bond';
        $agency = 'MI6';
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

        $repository->shouldReceive('create')
            ->withArgs(function ($name, $surname, $agency, $country, $birthDate, $deathDate) {
                return $name === 'James'
                    && $surname === 'Bond'
                    && $agency->toNative() === 'MI6'
                    && $country->toNative() === 'UK'
                    && $birthDate->isSameDay(Carbon::parse('1962-01-01'))
                    && $deathDate->isSameDay(Carbon::parse('1995-11-17'));
            })
            ->once();

        $handler = new CreateSpyCommandHandler($repository);
        $handler->handle($command);
    }
}
