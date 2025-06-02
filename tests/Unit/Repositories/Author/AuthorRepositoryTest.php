<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Author;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\Repositories\Author\AuthorRepository;
use App\Contracts\Repositories\Author\AuthorRepositoryContract;

use App\Models\Author\Author;

class AuthorRepositoryTest extends TestCase
{
    use RefreshDatabase, MockeryTearDown;

    #[Test]
    public function canFetchAllReturnsCollection(): void
    {
        $mock = \Mockery::mock(Author::class);
        $mock->shouldReceive('all')->once()->andReturn(new EloquentCollection());

        $repository = new class($mock) extends AuthorRepository implements AuthorRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $result = $repository->fetchAll();
        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFetchAllAndSortReturnsCollection(): void
    {
        $builder = \Mockery::mock(Builder::class);
        $builder->shouldReceive('with')->with(['country'])->andReturnSelf();
        $builder->shouldReceive('withCount')->with('books')->andReturnSelf();
        $builder->shouldReceive('orderBy')->with('id', 'asc')->andReturnSelf();
        $builder->shouldReceive('get')->andReturn(new EloquentCollection());

        $mock = \Mockery::mock(Author::class);
        $mock->shouldReceive('newQuery')->once()->andReturn($builder);

        $repository = new class($mock) extends AuthorRepository implements AuthorRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $result = $repository->fetchAllAndSort();
        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFindReturnsModelOrNull(): void
    {
        $mock = \Mockery::mock(Author::class);
        $mock->shouldReceive('find')->with(1)->once()->andReturn(null);

        $repository = new class($mock) extends AuthorRepository implements AuthorRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $this->assertNull($repository->find(1));
    }

    #[Test]
    public function canCheckIfExistsReturnsBoolean(): void
    {
        $mock = \Mockery::mock(Author::class);
        $mock->shouldReceive('where')->with('id', 1)->andReturnSelf();
        $mock->shouldReceive('exists')->once()->andReturnTrue();

        $repository = new class($mock) extends AuthorRepository implements AuthorRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $this->assertTrue($repository->checkIfExists(1));
    }

    #[Test]
    public function canFindByNameReturnsAuthorOrNull(): void
    {
        $query = \Mockery::mock(Builder::class);
        $query->shouldReceive('where')->with('name', 'John')->andReturnSelf();
        $query->shouldReceive('where')->with('surname', 'Doe')->andReturnSelf();
        $query->shouldReceive('first')->andReturn(null);

        $mock = \Mockery::mock(Author::class);
        $mock->shouldReceive('newQuery')->andReturn($query);

        $repository = new class($mock) extends AuthorRepository implements AuthorRepositoryContract {
            public function __construct($model) {
                $this->model = $model;
            }
        };

        $this->assertNull($repository->findByName('John', 'Doe'));
    }
}
