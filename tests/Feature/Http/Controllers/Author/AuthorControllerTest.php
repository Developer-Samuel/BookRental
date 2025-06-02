<?php

declare(strict_types=1);

namespace Tests\Feature\Http\Controllers\Author;

use PHPUnit\Framework\Attributes\Test;

use Tests\Feature\Core\BaseTestCase;

class AuthorControllerTest extends BaseTestCase
{
    #[Test]
    public function canDisplayAuthorsIndexPage()
    {
        $this->actingAs($this->createUser());
        $this->createAuthor();

        $response = $this->get(route('authors.index'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Authors/Index')
                 ->has('authors', 1)
        );
    }

    #[Test]
    public function canDisplayCreateAuthorPage()
    {
        $this->actingAs($this->createUser());

        $response = $this->get(route('authors.create'));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Authors/Create')
                 ->has('countries')
        );
    }

    #[Test]
    public function canStoreNewAuthor()
    {
        $this->actingAs($this->createUser());
        $country = $this->createCountry();

        $data = [
            'country_id' => $country->id,
            'name'       => 'Test Author',
            'surname'    => 'Test Surname',
            'gender'     => 'male',
            'birth_date' => '1985-06-15',
        ];

        $response = $this->post(route('authors.store'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', ['name' => 'Test Author']);
    }

    #[Test]
    public function canDisplayEditAuthorPage()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $response = $this->get(route('authors.edit', $author->id));

        $response->assertStatus(200);
        $response->assertInertia(fn ($page) =>
            $page->component('Pages/Authors/Edit')
                 ->has('model')
                 ->where('model.id', $author->id)
        );
    }

    #[Test]
    public function canUpdateAuthor()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $data = [
            'id'         => $author->id,
            'country_id' => $author->country_id,
            'name'       => 'Updated Author',
            'surname'    => 'Updated Surname',
            'gender'     => 'male',
            'birth_date' => '1976-06-13',
        ];

        $response = $this->post(route('authors.update'), $data);

        $response->assertStatus(200);
        $this->assertDatabaseHas('authors', ['name' => 'Updated Author']);
    }

    #[Test]
    public function canDeleteAuthor()
    {
        $this->actingAs($this->createUser());
        $author = $this->createAuthor();

        $response = $this->delete(route('authors.destroy', $author->id), ['id' => $author->id]);

        $response->assertStatus(200);
        $this->assertDatabaseMissing('authors', ['id' => $author->id]);
    }
}
