<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Enums;

use App\Models\Spy;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\BirthDateSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\DeathDateSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\FullNameSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\NameSortingStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Sorting\SurnameSortingStrategy;

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

    public static function columns(): array
    {
        return [
            Spy::COLUMN_SURNAME,
            Spy::COLUMN_NAME,
            Spy::COLUMN_FULL_NAME,
            Spy::COLUMN_BIRTH_DATE,
            Spy::COLUMN_DEATH_DATE,
        ];
    }

    case Surname = SurnameSortingStrategy::class;
    case Name = NameSortingStrategy::class;
    case FullName = FullNameSortingStrategy::class;
    case BirthDate = BirthDateSortingStrategy::class;
    case DeathDate = DeathDateSortingStrategy::class;
}
