<?php

declare(strict_types=1);

namespace App\Rules\Author;

use Illuminate\Contracts\Validation\ValidationRule;

use App\Enums\Gender;

class GenderRule implements ValidationRule
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
        $validGenders = Gender::values();

        if (!in_array($value, $validGenders, true)) {
            $fail('The selected $attribute is invalid.');
        }
    }
}
