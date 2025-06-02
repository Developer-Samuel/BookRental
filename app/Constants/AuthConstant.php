<?php

declare(strict_types=1);

namespace App\Constants;

final class AuthConstant
{
    public const ATTEMPTS_KEY = 'login_attempts';
    public const LAST_ATTEMPT_AT_KEY = 'login_last_attempt_at';
    public const LOCKOUT_SECONDS = 60;
    public const MAX_ATTEMPTS = 5;
}