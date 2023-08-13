<?php

declare(strict_types = 1);

namespace Prosperty\Core\Common\ValueObjects;

interface BaseValueObject
{
    public static function fromString(string $value): static;

    public function toNative(): string;
}
