<?php

declare(strict_types=1);

namespace App\Contracts\Services\Auth;

interface AuthServiceContract
{
    /**
     * Attempt to log in a user by email and password.
     *
     * @param string $email
     * @param string $password
     * @return void
    */
    public function login(string $email, string $password): void;

    /**
     * Log out the current user and invalidate the session.
     *
     * @return void
    */
    public function logout(): void;
}