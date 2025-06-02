<?php

declare(strict_types=1);

namespace App\Rules\Author;

use Illuminate\Contracts\Validation\ValidationRule;

class NameRule implements ValidationRule
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
        $length = strlen($value);

        if ($length < 2) {
            $fail("The $attribute must be at least 2 characters long.");
            return;
        }

        if ($length > 100) {
            $fail("The $attribute must not be longer than 100 characters.");
            return;
        }

        if (!preg_match("/^[\p{L}\s'\.\-]+$/u", $value)) {
            $fail("The $attribute may only contain letters, spaces, apostrophes, hyphens and dots.");
        }
    }
}
