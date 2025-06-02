<?php

declare(strict_types=1);

namespace App\Policies\Author;

use App\Models\User\User;
use App\Models\Author\Author;

final class AuthorPolicy
{
    /**
     * Determine if the given user can create an author.
     *
     * @param User $user
     * @return bool
    */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given user can update the given author.
     *
     * @param User $user
     * @param Author $author
     * @return bool
    */
    public function update(User $user, Author $author): bool
    {
        return true;
    }

    /**
     * Determine if the given user can delete the given author.
     *
     * @param User $user
     * @param Author $author
     * @return bool
    */
    public function delete(User $user, Author $author): bool
    {
        return true;
    }
}
