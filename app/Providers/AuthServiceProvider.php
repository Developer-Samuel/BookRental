<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Policies\Author\AuthorPolicy;
use App\Policies\Book\BookPolicy;

use App\Models\Author\Author;
use App\Models\Book\Book;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any policies.
    */
    protected $policies = [
        Author::class => AuthorPolicy::class,
        Book::class   => BookPolicy::class
    ];

    /**
     * Bootstrap any policies.
    */
    public function boot(): void
    {
        $this->registerPolicies();
    }
}
