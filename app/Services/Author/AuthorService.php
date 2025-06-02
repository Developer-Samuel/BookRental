<?php

declare(strict_types=1);

namespace App\Services\Author;

use App\Core\Abstracts\BaseService;

use App\Contracts\Services\Author\AuthorServiceContract;

use App\Models\Author\Author;

class AuthorService extends BaseService implements AuthorServiceContract
{
    /**
     * AuthorService constructor.
     *
     * @param Author|null $model
    */
    public function __construct(?Author $model = null)
    {
        parent::__construct($model);
    }

    protected function getModelClass(): string
    {
        return Author::class;
    }
}
