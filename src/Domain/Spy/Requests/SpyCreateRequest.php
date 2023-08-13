<?php

namespace Prosperty\Core\Domain\Spy\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Prosperty\Core\Domain\Spy\Enums\Permission;
use Prosperty\Core\Domain\Spy\Rules\ValidAgency;

class SpyCreateRequest extends FormRequest
{
    public function __construct(
        protected ValidAgency $validAgency,
    ) {
        parent::__construct();
    }

    public function authorize(Request $request): bool
    {
        return $request->user()->tokenCan(Permission::CREATE->value);
    }

    public function rules(): array
    {
        return [
            'name'               => ['required', 'string'],
            'surname'            => ['required', 'string'],
            'agency'             => ['nullable', 'string', $this->validAgency],
            'countryOfOperation' => ['required', 'string'],
            'birthDate'          => ['required', 'date', 'before_or_equal:today'],
            'deathDate'          => ['nullable', 'date', 'after:birthDate', 'before_or_equal:today'],
        ];
    }
}
