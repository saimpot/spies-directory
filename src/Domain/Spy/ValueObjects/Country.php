<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Prosperty\Core\Common\ValueObjects\BaseValueObject;

class Country implements BaseValueObject
{
    public function __construct(
        protected string $country,
    ) {
    }

    public static function fromString(string $value): static
    {
        return new self($value);
    }

    public function toNative(): string
    {
        return $this->country;
    }
}
