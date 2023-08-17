<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Enums;

use App\Models\Spy;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\Strategies\Filtering\AgeFilteringStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Filtering\NameFilteringStrategy;
use Prosperty\Core\Domain\Spy\Strategies\Filtering\SurnameFilteringStrategy;

enum FilteringStrategies: string
{
    public static function fromString(string $strategy): FilteringStrategies
    {
        return match (strtolower($strategy)) {
            Spy::COLUMN_NAME    => self::Name,
            Spy::COLUMN_SURNAME => self::Surname,
            Spy::COLUMN_AGE     => self::Age,
            default             => throw new InvalidArgumentException("Invalid filtering strategy: {$strategy}"),
        };
    }

    public static function columns(): array
    {
        return [
            Spy::COLUMN_NAME,
            Spy::COLUMN_SURNAME,
            Spy::COLUMN_AGE,
        ];
    }

    case Name = NameFilteringStrategy::class;
    case Surname = SurnameFilteringStrategy::class;
    case Age = AgeFilteringStrategy::class;
}
