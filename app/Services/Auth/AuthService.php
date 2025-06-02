<?php

declare(strict_types=1);

namespace App\Services\Auth;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Exceptions\HttpResponseException;

use App\Contracts\Services\Auth\AuthServiceContract;

use App\Models\User\User;

final class AuthService implements AuthServiceContract
{
    /**
     * Attempt to log in a user by email and password.
     *
     * @param string $email
     * @param string $password
     * @return void
    */
    public function login(string $email, string $password): void
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            throw new HttpResponseException(response()->json([
                'message' => 'Incorrect login details.'
            ], 422));
        }

        Auth::login($user);
    }

    /**
     * Log out the current user and invalidate the session.
     *
     * @return void
    */
    public function logout(): void
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();
    }
}