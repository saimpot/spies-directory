<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use Prosperty\Core\Common\ValueObjects\BaseValueObject;

class Agency implements BaseValueObject
{
    public function __construct(
        protected string $agency,
    ) {
    }

    public static function fromString(string $value): static
    {
        return new self($value);
    }

    public function toNative(): string
    {
        return $this->agency;
    }
}
