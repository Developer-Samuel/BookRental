<?php

declare(strict_types=1);

namespace Tests\Unit\Repositories\Core;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;

use App\Core\Abstracts\BaseRepository;

use App\Contracts\Abstracts\BaseRepositoryContract;

class BaseRepositoryTest extends TestCase
{
    use MockeryTearDown;

    protected $mockModel;
    protected $repository;

    #[Test]
    public function canFetchAllReturnsCollection(): void
    {
        $this->mockModel->shouldReceive('all')
            ->once()
            ->andReturn(new EloquentCollection());

        $result = $this->repository->fetchAll();

        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFetchAllAndSortWithRelationsReturnsCollection(): void
    {
        $mockQuery = \Mockery::mock(Builder::class);
        $mockQuery->shouldReceive('with')
            ->once()
            ->with(['relation1', 'relation2'])
            ->andReturnSelf();

        $mockQuery->shouldReceive('orderBy')
            ->once()
            ->with('name', 'desc')
            ->andReturnSelf();

        $mockQuery->shouldReceive('get')
            ->once()
            ->andReturn(new EloquentCollection());

        $this->mockModel->shouldReceive('newQuery')
            ->once()
            ->andReturn($mockQuery);

        $result = $this->repository->fetchAllAndSort('name', 'desc', ['relation1', 'relation2']);

        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFetchAllAndSortWithoutRelationsReturnsCollection(): void
    {
        $mockQuery = \Mockery::mock(Builder::class);
        $mockQuery->shouldReceive('orderBy')
            ->once()
            ->with('id', 'asc')
            ->andReturnSelf();
        $mockQuery->shouldReceive('get')
            ->once()
            ->andReturn(new EloquentCollection());

        $this->mockModel->shouldReceive('newQuery')
            ->once()
            ->andReturn($mockQuery);

        $result = $this->repository->fetchAllAndSort();

        $this->assertInstanceOf(EloquentCollection::class, $result);
    }

    #[Test]
    public function canFindReturnsModelOrNull(): void
    {
        $this->mockModel->shouldReceive('find')
            ->once()
            ->with(10)
            ->andReturn(null);

        $result = $this->repository->find(10);

        $this->assertNull($result);
    }

    #[Test]
    public function canCheckIfExistsReturnsBool(): void
    {
        $this->mockModel->shouldReceive('where')
            ->once()
            ->with('id', 5)
            ->andReturnSelf();

        $this->mockModel->shouldReceive('exists')
            ->once()
            ->andReturn(true);

        $result = $this->repository->checkIfExists(5);

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->mockModel = \Mockery::mock(Model::class);

        $this->repository = new class($this->mockModel) extends BaseRepository implements BaseRepositoryContract {
            //
        };
    }
}
