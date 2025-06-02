<?php

declare(strict_types=1);

namespace App\Rules\Book;

use Illuminate\Contracts\Validation\ValidationRule;

class IsBorrowedRule implements ValidationRule
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
        if (!in_array($value, [0, 1, '0', '1'], true)) {
            $fail('The $attribute must be true or false.');
        }
    }
}
