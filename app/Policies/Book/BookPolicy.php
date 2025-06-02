<?php

declare(strict_types=1);

namespace App\Policies\Book;

use App\Models\User\User;
use App\Models\Book\Book;

final class BookPolicy
{
    /**
     * Determine if the given user can create an book.
     *
     * @param User $user
     * @return bool
    */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine if the given user can update the given book.
     *
     * @param User $user
     * @param Book $book
     * @return bool
    */
    public function update(User $user, Book $book): bool
    {
        return true;
    }

    /**
     * Determine if the given user can delete the given book.
     *
     * @param User $user
     * @param Book $book
     * @return bool
    */
    public function delete(User $user, Book $book): bool
    {
        return true;
    }
}
