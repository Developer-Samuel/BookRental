<?php

declare(strict_types=1);

namespace App\Views\Author;

use Illuminate\Database\Eloquent\Collection;

use App\Models\Author\Author;

final class AuthorView
{
    /**
     * Prepare data for authors index page.
     *
     * @param Collection $authors
     * @return array
    */
    public function index(Collection $authors): array
    {
        return [
            'view'  => 'Pages/Authors/Index',
            'props' => ['authors' => $authors]
        ];
    }

    /**
     * Prepare data for authors create page.
     *
     * @param array $countries
     * @param array $genders
     * @return array
    */
    public function create(array $countries, array $genders): array
    {
        return [
            'view'  => 'Pages/Authors/Create',
            'props' => [
                'countries' => $countries,
                'genders'   => $genders,
            ]
        ];
    }

    /**
     * Prepare data for authors edit page.
     *
     * @param Author $author
     * @param array $countries
     * @param array $genders
     * @return array
    */
    public function edit(Author $author, array $countries, array $genders): array
    {
        return [
            'view'  => 'Pages/Authors/Edit',
            'props' => [
                'countries' => $countries,
                'genders'   => $genders,
                'fullName'  => $author->name . ' ' . $author->surname,
                'author'    => $author,
            ]
        ];
    }
}
