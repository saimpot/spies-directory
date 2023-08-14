<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Enums;

use App\Models\Spy;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\Strategies\BirthDateSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\DeathDateSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\FullNameSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\NameSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\SurnameSortingStrategy;

enum SortingStrategies: string
{
    public static function fromString(string $strategy): SortingStrategies
    {
        return match (strtolower($strategy)) {
            Spy::COLUMN_SURNAME    => self::Surname,
            Spy::COLUMN_NAME       => self::Name,
            Spy::COLUMN_FULL_NAME  => self::FullName,
            Spy::COLUMN_BIRTH_DATE => self::BirthDate,
            Spy::COLUMN_DEATH_DATE => self::DeathDate,
            default                => throw new InvalidArgumentException("Invalid sorting strategy: {$strategy}"),
        };
    }

    case Surname = SurnameSortingStrategy::class;
    case Name = NameSortingStrategy::class;
    case FullName = FullNameSortingStrategy::class;
    case BirthDate = BirthDateSortingStrategy::class;
    case DeathDate = DeathDateSortingStrategy::class;
}
