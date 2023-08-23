<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Casts;

use App\Models\Spy;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\ValueObjects\FullName;

class FullNameCast implements CastsAttributes
{
    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return (new FullName($attributes[Spy::COLUMN_NAME], $attributes[Spy::COLUMN_SURNAME]))->toNative();
    }

    public function set($model, $key, $value, $attributes): string
    {
        if (!$value instanceof FullName) {
            throw new InvalidArgumentException('The given value is not a FullName instance.');
        }

        return $value->toNative();
    }
}
