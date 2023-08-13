<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Commands;

use App\Models\Spy;
use Illuminate\Support\Carbon;
use Prosperty\Core\Common\Bus\CommandHandler;
use Prosperty\Core\Domain\Spy\Repositories\WriteSpyRepositoryInterface;
use Prosperty\Core\Domain\Spy\ValueObjects\Agency;
use Prosperty\Core\Domain\Spy\ValueObjects\Country;

class CreateSpyCommandHandler extends CommandHandler
{
    public function __construct(
        protected WriteSpyRepositoryInterface $repository
    ) {
    }

    public function handle(CreateSpyCommand $command): Spy
    {
        return $this->repository->create(
            $command->name,
            $command->surname,
            Agency::fromString($command->agency),
            Country::fromString($command->countryOfOperation),
            Carbon::parse($command->birthDate),
            Carbon::parse($command->deathDate),
        );
    }
}
