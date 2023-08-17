<?php

namespace Prosperty\Core\Domain\Spy\Resources;

use App\Models\Spy;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SpyResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Spy $this */
        return [
            Spy::COLUMN_NAME                 => $this->name,
            Spy::COLUMN_SURNAME              => $this->surname,
            Spy::COLUMN_AGENCY               => $this->agency,
            Spy::COLUMN_COUNTRY_OF_OPERATION => $this->country_of_operation,
            Spy::COLUMN_BIRTH_DATE           => $this->birth_date,
            Spy::COLUMN_DEATH_DATE           => $this->death_date,
            Spy::COLUMN_FULL_NAME            => $this->full_name->toNative(),
            Spy::COLUMN_AGE                  => $this->age->toNative(),
        ];
    }
}
