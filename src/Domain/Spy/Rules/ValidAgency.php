<?php

namespace Prosperty\Core\Domain\Spy\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidAgency implements ValidationRule
{
    public function __construct(
        protected AgencyListProviderInterface $listProvider
    ) {
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!$this->listProvider->isKnownAgency($value)) {
            $fail("{$value} is not in the list of known agencies.");
        }
    }
}
