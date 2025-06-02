<?php

declare(strict_types=1);

namespace App\Rules\Author;

use Illuminate\Contracts\Validation\ValidationRule;
use Carbon\Carbon;

class BirthDateRule implements ValidationRule
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
        if (!$value) {
            return;
        }

        $minAge = 12;

        try {
            $birthDate = Carbon::parse($value);
        } catch (\Exception $e) {
            $fail("Invalid birth date format.");
            return;
        }

        $now = Carbon::now();
        $minDate = $now->copy()->subYears($minAge);

        if ($birthDate->greaterThan($now)) {
            $fail("You entered a future date.");
            return;
        }

        if ($birthDate->greaterThan($minDate)) {
            $fail("Minimum age is {$minAge} years.");
        }
    }
}
