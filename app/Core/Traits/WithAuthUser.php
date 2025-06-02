<?php

declare(strict_types=1);

namespace App\Core\Traits;

use Illuminate\Support\Facades\Auth;

use App\Models\User\User;

trait WithAuthUser
{
    protected function getUser(): User
    {
        return Auth::user();
    }
}
