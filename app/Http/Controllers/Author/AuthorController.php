<?php

declare(strict_types=1);

namespace App\Http\Controllers\Author;

use Illuminate\Database\Eloquent\Model;

use App\Core\Abstracts\BaseController;
use App\Core\Helpers\DateFormatter;

use App\Http\Requests\Author\StoreAuthorRequest;
use App\Http\Requests\Author\UpdateAuthorRequest;

use App\Services\Common\ErrorLogger;

use App\Contracts\Repositories\Author\AuthorRepositoryContract;
use App\Contracts\Services\Author\AuthorServiceContract;
use App\Contracts\Services\Cache\CountryCacheServiceContract;
use App\Contracts\Services\Cache\GenderCacheServiceContract;

use App\DTO\Author\AuthorDTO;
use App\Views\Author\AuthorView;

use App\Enums\AuthorOrderBy;
use App\Enums\Direction;

use App\Models\Author\Author;

class AuthorController extends BaseController
{
    /**
     * @param AuthorRepositoryContract $authorRepository
     * @param AuthorServiceContract $authorService
     * @param CountryCacheServiceContract $countryCacheService
     * @param GenderCacheServiceContract $genderCacheService
     * @param AuthorView $authorView
     * @param ErrorLogger $errorLogger
    */
    public function __construct(
        private readonly AuthorRepositoryContract $authorRepository,
        private readonly AuthorServiceContract $authorService,
        private readonly CountryCacheServiceContract $countryCacheService,
        private readonly GenderCacheServiceContract $genderCacheService,
        private readonly AuthorView $authorView,
        ErrorLogger $errorLogger
    ) {
        parent::__construct($errorLogger);
    }

    /**
     * @return AuthorRepositoryContract
    */
    protected function repository(): AuthorRepositoryContract
    {
        return $this->authorRepository;
    }

    /**
     * @return AuthorServiceContract
    */
    protected function service(): AuthorServiceContract
    {
        return $this->authorService;
    }

    /**
     * @return array
    */
    protected function getIndexViewData(): array
    {
        $orderByValue = request()->query('orderBy', AuthorOrderBy::NAME->value);
        $directionValue = strtolower(request()->query('direction', Direction::ASC->value));

        $orderBy = AuthorOrderBy::tryFrom($orderByValue) ?? AuthorOrderBy::NAME;
        $direction = Direction::tryFrom($directionValue) ?? Direction::ASC;

        $authors = $this->authorRepository->fetchAllAndSort($orderBy->value, $direction->value);

        $authors = $authors->map(function (Model $author, int|string $key): Author {
            /** @var Author $author */
            $author->birth_date = DateFormatter::format($author->birth_date);
            return $author;
        });

        return $this->authorView->index($authors);
    }

    /**
     * @return array
    */
    protected function getCreateViewData(): array
    {
        $countries = $this->countryCacheService->getAllSorted();
        $genders = $this->genderCacheService->getLabels();

        return $this->authorView->create($countries, $genders);
    }

    /**
     * @return string
    */
    protected function getFormRequestClass(): string
    {
        return StoreAuthorRequest::class;
    }

    /**
     * @param object $author
     * @return array
    */
    protected function getEditViewData(object $author): array
    {
        $countries = $this->countryCacheService->getAllSorted();
        $genders = $this->genderCacheService->getLabels();

        return $this->authorView->edit($author, $countries, $genders);
    }

    /**
     * @return string
    */
    protected function getUpdateFormRequestClass(): string
    {
        return UpdateAuthorRequest::class;
    }

    /**
     * @return string
    */
    protected function getDTOClass(): string
    {
        return AuthorDTO::class;
    }
}
