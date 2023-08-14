<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\ValueObjects;

use InvalidArgumentException;
use Prosperty\Core\Common\ValueObjects\BaseValueObject;

class FullName implements BaseValueObject
{
    public function __construct(
        protected string $name,
        protected string $surname,
    ) {
    }

    public static function fromString(string $value): static
    {
        throw new InvalidArgumentException('FullName must be created from array.');
    }

    public static function fromArray(array $values): static
    {
        return new self(...$values);
    }

    public function toNative(): string
    {
        return sprintf(
            '%s, %s %s',
            $this->surname, $this->name, $this->surname
        );
    }
}
