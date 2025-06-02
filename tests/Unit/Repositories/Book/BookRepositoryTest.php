<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Book;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use App\Repositories\Book\BookRepository;
use App\Contracts\Repositories\Book\BookRepositoryContract;

use App\Models\Book\Book;

class BookRepositoryTest extends TestCase
{
    use MockeryTearDown;

    #[Test]
    public function canFetchAllForAuthor(): void
    {
        $mock = \Mockery::mock(Book::class);
        $mock->shouldReceive('where')
            ->with('author_id', 1)
            ->andReturnSelf();
        $mock->shouldReceive('get')
            ->once()
            ->andReturn(new EloquentCollection());

        $repository = new class($mock) extends BookRepository implements BookRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $result = $repository->fetchAllForAuthor(1);
        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFetchAllByAuthorAndSort(): void
    {
        $builder = \Mockery::mock(Builder::class);
        $builder->shouldReceive('where')
            ->with('author_id', 1)
            ->andReturnSelf();
        $builder->shouldReceive('orderBy')
            ->with('id', 'asc')
            ->andReturnSelf();
        $builder->shouldReceive('get')
            ->once()
            ->andReturn(new EloquentCollection());

        $mock = \Mockery::mock(Book::class);
        $mock->shouldReceive('where')
            ->with('author_id', 1)
            ->andReturn($builder);

        $repository = new class($mock) extends BookRepository implements BookRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $result = $repository->fetchAllByAuthorAndSort(1, 'id', 'asc');
        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFindByTitleReturnsNullIfNotFound(): void
    {
        $builder = \Mockery::mock(Builder::class);
        $builder->shouldReceive('where')
            ->with('title', 'Test Title')
            ->andReturnSelf();
        $builder->shouldReceive('first')
            ->once()
            ->andReturn(null);

        $mock = \Mockery::mock(Book::class);
        $mock->shouldReceive('where')
            ->with('title', 'Test Title')
            ->andReturn($builder);

        $repository = new class($mock) extends BookRepository implements BookRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $this->assertNull($repository->findByTitle('Test Title'));
    }
}
