<?php

declare(strict_types=1);

namespace App\Rules\Book;

use Illuminate\Contracts\Validation\ValidationRule;

class TitleRule implements ValidationRule
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
            $fail('The $attribute must not be longer than 100 characters.');
        }
    }
}
