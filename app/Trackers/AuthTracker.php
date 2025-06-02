<?php

declare(strict_types=1);

namespace App\Trackers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Carbon;

use App\Constants\AuthConstant;

final class AuthTracker
{
    /**
     * Increment the number of login attempts and update the timestamp.
     *
     * @return void
    */
    public function incrementAttempts(): void
    {
        $attempts = (int) Session::get(AuthConstant::ATTEMPTS_KEY, 0);
        Session::put(AuthConstant::ATTEMPTS_KEY, $attempts + 1);
        Session::put(AuthConstant::LAST_ATTEMPT_AT_KEY, Carbon::now()->timestamp);
    }

    /**
     * Check if the user has exceeded max login attempts and is locked out.
     *
     * @return bool
    */
    public function tooManyAttempts(): bool
    {
        $attempts = (int) Session::get(AuthConstant::ATTEMPTS_KEY, 0);
        $lastAttempt = (int) Session::get(AuthConstant::LAST_ATTEMPT_AT_KEY, 0);

        if ($attempts < AuthConstant::MAX_ATTEMPTS) {
            return false;
        }

        $lastAttemptSecs = Carbon::now()->timestamp - $lastAttempt;

        if ($lastAttemptSecs >= AuthConstant::LOCKOUT_SECONDS) {
            $this->clearAttempts();
            return false;
        }

        return true;
    }

    /**
     * Clear login attempts and timestamp.
     *
     * @return void
    */
    public function clearAttempts(): void
    {
        Session::forget(AuthConstant::ATTEMPTS_KEY);
        Session::forget(AuthConstant::LAST_ATTEMPT_AT_KEY);
    }

    /**
     * Return remaining lockout time in seconds.
     *
     * @return int
    */
    public function lockoutTimeLeft(): int
    {
        $lastAttempt = (int) Session::get(AuthConstant::LAST_ATTEMPT_AT_KEY, 0);
        $lastAttemptSecs = Carbon::now()->timestamp - $lastAttempt;

        return max(0, AuthConstant::LOCKOUT_SECONDS - $lastAttemptSecs);
    }
}
