<?php

declare(strict_types = 1);

namespace Prosperty\Core\Domain\Spy\Casts;

use App\Models\Spy;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use InvalidArgumentException;
use Prosperty\Core\Domain\Spy\ValueObjects\Age;

class AgeCast implements CastsAttributes
{

    public function get(Model $model, string $key, mixed $value, array $attributes): string
    {
        return (new Age(
            Carbon::parse($attributes[Spy::COLUMN_BIRTH_DATE]),
            Carbon::parse($attributes[Spy::COLUMN_DEATH_DATE]))
        )->toNative();
    }

    public function set(Model $model, string $key, mixed $value, array $attributes): string
    {
        if (! $value instanceof Age) {
            throw new InvalidArgumentException('The given value is not an Age instance.');
        }

        return $value->toNative();
    }
}
