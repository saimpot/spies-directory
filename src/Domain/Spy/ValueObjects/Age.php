<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Illuminate\Support\Carbon;
use Prosperty\Core\Common\ValueObjects\BaseValueObject;

class Age implements BaseValueObject
{
    protected const SEPARATOR = '-';

    public function __construct(
        protected Carbon $birthDate,
        protected ?Carbon $deathDate = null
    ) {
    }

    public static function fromString(string $value): static
    {
        $dates = explode(self::SEPARATOR, $value);

        return new static(
            Carbon::createFromFormat('Y-m-d', $dates[0]),
            isset($dates[1]) ? Carbon::createFromFormat('Y-m-d', $dates[1]) : null
        );
    }

    public function toNative(): string
    {
        return (string) $this->determineAge();
    }

    public static function isExactAge(string $value): bool
    {
        return count(explode(self::SEPARATOR, $value)) === 1;
    }

    private function determineAge(): int
    {
        return $this->birthDate->diffInYears($this->deathDate ?? Carbon::now());
    }
}
