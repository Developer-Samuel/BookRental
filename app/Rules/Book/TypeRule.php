<?php

declare(strict_types=1);

namespace App\Rules\Book;

use Illuminate\Contracts\Validation\ValidationRule;

use App\Enums\BookType;

class TypeRule implements ValidationRule
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
        if (!in_array($value, BookType::values(), true)) {
            $fail('The selected $attribute is invalid.');
        }
    }
}
