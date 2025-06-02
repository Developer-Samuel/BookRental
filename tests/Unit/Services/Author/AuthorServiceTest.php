<?php

declare(strict_types=1);

namespace Tests\Unit\Services\Author;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\Traits\MockeryTearDown;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use App\Services\Author\AuthorService;
use App\Contracts\Services\Author\AuthorServiceContract;

use App\Models\User\User;
use App\Models\Author\Author;

use Tests\Unit\Fakes\Data\FakeDto;

class AuthorServiceTest extends TestCase
{
    use MockeryTearDown;

    protected AuthorService $service;
    protected $authorMock;

    #[Test]
    public function canGetModelReturnsModelInstance(): void
    {
        $model = $this->service->getModel();
        $this->assertSame($this->authorMock, $model);
    }

    #[Test]
    public function canCreateCallsModelCreateAndReturnsModel(): void
    {
        $data = ['name' => 'John Doe'];
        $dto = new FakeDto($data);

        $this->authorMock
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
        $data = ['name' => 'Jane Doe'];
        $dto = new FakeDto($data);

        $modelMock = \Mockery::mock(Model::class);
        $modelMock->shouldReceive('update')->once()->with($data)->andReturnTrue();
        $modelMock->shouldReceive('refresh')->once()->andReturnSelf();

        $this->authorMock
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
        $data = ['name' => 'Nobody'];
        $dto = new FakeDto($data);

        $this->authorMock
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

        $this->authorMock
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

        $this->authorMock
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

        $this->authorMock = \Mockery::mock(Author::class);

        $this->service = new class($this->authorMock) extends AuthorService implements AuthorServiceContract {
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
