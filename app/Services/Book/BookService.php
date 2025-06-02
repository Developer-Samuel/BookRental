<?php

declare(strict_types=1);

namespace App\Services\Book;

use App\Core\Abstracts\BaseService;

use App\Contracts\Services\Book\BookServiceContract;

use App\Models\Book\Book;

class BookService extends BaseService implements BookServiceContract
{
    /**
     * BookService constructor.
     *
     * @param Book|null $model
    */
    public function __construct(?Book $model = null)
    {
        parent::__construct($model);
    }

    protected function getModelClass(): string
    {
        return Book::class;
    }
}
