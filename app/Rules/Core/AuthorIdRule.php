<?php

declare(strict_types=1);

namespace App\Rules\Core;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Log;

use App\Models\Author\Author;

class AuthorIdRule implements ValidationRule
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
        Log::info("AuthorIdRule checking: $value");

        if (!Author::where('id', $value)->exists()) {
            $fail("Selected author is not active.");
        }
    }
}
