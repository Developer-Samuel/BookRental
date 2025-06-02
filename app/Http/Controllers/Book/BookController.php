<?php

declare(strict_types=1);

namespace App\Http\Controllers\Book;

use App\Core\Abstracts\BaseController;

use App\Http\Requests\Book\StoreBookRequest;
use App\Http\Requests\Book\UpdateBookRequest;

use App\Services\Common\ErrorLogger;

use App\Contracts\Repositories\Book\BookRepositoryContract;
use App\Contracts\Services\Book\BookServiceContract;
use App\Contracts\Services\Cache\BookTypeCacheServiceContract;
use App\Contracts\Services\Cache\BorrowStatusCacheServiceContract;

use App\DTO\Book\BookDTO;
use App\Views\Book\BookView;

use App\Enums\BookOrderBy;
use App\Enums\Direction;

class BookController extends BaseController
{
    /**
     * @param BookServiceContract $bookService
     * @param BookRepositoryContract $bookRepository
     * @param BookTypeCacheServiceContract $bookTypeCacheService
     * @param BorrowStatusCacheServiceContract $borrowStatusCacheService
     * @param BookView $bookView
     * @param ErrorLogger $errorLogger
    */
    public function __construct(
        private readonly BookServiceContract $bookService,
        private readonly BookRepositoryContract $bookRepository,
        private readonly BookTypeCacheServiceContract $bookTypeCacheService,
        private readonly BorrowStatusCacheServiceContract $borrowStatusCacheService,
        private readonly BookView $bookView,
        ErrorLogger $errorLogger,
    ) {
        parent::__construct($errorLogger);
    }

    /**
     * @return BookRepositoryContract
    */
    protected function repository(): BookRepositoryContract
    {
        return $this->bookRepository;
    }

    /**
     * @return BookServiceContract
    */
    protected function service(): BookServiceContract
    {
        return $this->bookService;
    }

    /**
     * @return array
    */
    protected function getIndexViewData(): array
    {
        $authorId = request()->route('id');

        if (!is_numeric($authorId) || intval($authorId) != $authorId) {
            abort(404);
        }

        $authorId = intval($authorId);

        $orderByValue = request()->query('orderBy', BookOrderBy::TITLE->value);
        $directionValue = strtolower(request()->query('direction', Direction::ASC->value));

        $orderBy = BookOrderBy::tryFrom($orderByValue) ?? BookOrderBy::TITLE;
        $direction = Direction::tryFrom($directionValue) ?? Direction::ASC;

        $this->bookRepository->fetchAllByAuthorAndSort($authorId, $orderBy->value, $direction->value);

        return $this->bookView->index($authorId);
    }

    /**
     * @return array
    */
    protected function getCreateViewData(): array
    {
        $authorId = intval(request()->route('id'));

        $types = $this->bookTypeCacheService->getOptions();
        $borrowStatuses = $this->borrowStatusCacheService->getOptions();

        return $this->bookView->create($authorId, $types, $borrowStatuses);
    }

    /**
     * @return string
    */
    protected function getFormRequestClass(): string
    {
        return StoreBookRequest::class;
    }

    /**
     * @param object $book
     * @return array
    */
    protected function getEditViewData(object $book): array
    {
        $types = $this->bookTypeCacheService->getOptions();
        $borrowStatuses = $this->borrowStatusCacheService->getOptions();

        return $this->bookView->edit($book, $types, $borrowStatuses);
    }

    /**
     * @return string
    */
    protected function getUpdateFormRequestClass(): string
    {
        return UpdateBookRequest::class;
    }

    /**
     * @return string
    */
    protected function getDTOClass(): string
    {
        return BookDTO::class;
    }
}
