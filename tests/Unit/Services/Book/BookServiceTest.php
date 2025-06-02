<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Book;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use App\Services\Book\BookService;
use App\Contracts\Services\Book\BookServiceContract;

use App\Models\Book\Book;
use App\Models\User\User;

use Tests\Unit\Fakes\Data\FakeDto;

class BookServiceTest extends TestCase
{
    use MockeryTearDown;

    protected BookService $service;
    protected $bookMock;

    #[Test]
    public function canGetModelReturnsModelInstance(): void
    {
        $model = $this->service->getModel();
        $this->assertSame($this->bookMock, $model);
    }

    #[Test]
    public function canCreateCallsModelCreateAndReturnsModel(): void
    {
        $data = ['title' => 'Sample Book'];
        $dto = new FakeDto($data);

        $this->bookMock
            ->shouldReceive('create')
            ->once()
            ->with($data)
            ->andReturnSelf();

        $result = $this->service->create($dto);
        $this->assertInstanceOf(Model::class, $result);
    }

    #[Test]
    public function canUpdateCallsFindAndUpdateAndReturnsModel(): void
    {
        $id = 1;
        $data = ['title' => 'Updated Book'];
        $dto = new FakeDto($data);

        $modelMock = \Mockery::mock(Model::class);
        $modelMock->shouldReceive('update')->once()->with($data)->andReturnTrue();
        $modelMock->shouldReceive('refresh')->once()->andReturnSelf();

        $this->bookMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($modelMock);

        $result = $this->service->update($id, $dto);

        $this->assertInstanceOf(Model::class, $result);
    }

    #[Test]
    public function canUpdateThrowsErrorIfModelNotFound(): void
    {
        $id = 999;
        $data = ['title' => 'Non-existing Book'];
        $dto = new FakeDto($data);

        $this->bookMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage("Model with ID {$id} not found.");

        $this->service->update($id, $dto);
    }

    #[Test]
    public function canDeleteReturnsFalseIfModelNotFound(): void
    {
        $id = 999;

        $this->bookMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn(null);

        $result = $this->service->delete($id);

        $this->assertFalse($result);
    }

    #[Test]
    public function canDeleteReturnsTrueIfModelDeleted(): void
    {
        $id = 1;

        $modelMock = \Mockery::mock(Model::class);
        $modelMock->shouldReceive('delete')->once()->andReturnTrue();

        $this->bookMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($modelMock);

        $result = $this->service->delete($id);

        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->bookMock = \Mockery::mock(Book::class);

        $this->service = new class($this->bookMock) extends BookService implements BookServiceContract {
            public function __construct($model) {
                parent::__construct($model);
            }

            public function getUser(): User
            {
                return \Mockery::mock(User::class);
            }
        };

        Gate::shouldReceive('forUser')
            ->andReturnSelf();

        Gate::shouldReceive('authorize')
            ->andReturnTrue();
    }
}
