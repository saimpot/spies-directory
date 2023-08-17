<?php

namespace Prosperty\Core\Domain\Spy\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Prosperty\Core\Domain\Spy\Enums\FilteringStrategies;
use Prosperty\Core\Domain\Spy\Enums\Permission;

class SpyFilterRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        return $request->user()->tokenCan(Permission::RETRIEVE->value);
    }

    public function rules(): array
    {
        return array_fill_keys(FilteringStrategies::columns(), 'sometimes|string|max:255');
    }
}
