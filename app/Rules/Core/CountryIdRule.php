<?php

declare(strict_types=1);

namespace App\Rules\Core;

use Illuminate\Contracts\Validation\ValidationRule;

use App\Models\Country\Country;

class CountryIdRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param string $attribute
     * @param mixed $value
     * @param \Closure $fail
     * @return void
    */
    public function validate(string $attribute, mixed $value, \Closure $fail): void
    {
        if (!Country::where('id', $value)->exists()) {
            $fail("Selected country is not active.");
        }
    }
}
