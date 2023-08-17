<?php

namespace Prosperty\Core\Domain\Spy\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Prosperty\Core\Domain\Spy\Enums\Permission;
use Prosperty\Core\Domain\Spy\Enums\SortingStrategies;

class SpySortRequest extends FormRequest
{
    public function authorize(Request $request): bool
    {
        return $request->user()->tokenCan(Permission::RETRIEVE->value);
    }

    public function rules(): array
    {
        return array_fill_keys(SortingStrategies::columns(), 'sometimes|string|max:255');
    }
}
