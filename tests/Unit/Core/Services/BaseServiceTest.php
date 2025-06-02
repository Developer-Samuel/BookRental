<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Services;

use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes\Test;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Gate;

use App\Core\Abstracts\BaseService;

use App\Models\User\User;

use Tests\Unit\Fakes\Data\FakeDto;
use Tests\Unit\Fakes\Models\FakeModel;

class BaseServiceTest extends TestCase
{
    /** @var \PHPUnit\Framework\MockObject\MockObject&\Illuminate\Database\Eloquent\Model */
    protected $modelMock;

    /** @var \PHPUnit\Framework\MockObject\MockObject&\Illuminate\Database\Eloquent\Builder */
    protected $builderMock;

    /** @var \PHPUnit\Framework\MockObject\MockObject&\App\Core\Abstracts\BaseService */
    protected $service;

    #[Test]
    public function canGetModelReturnsModel(): void
    {
        $this->assertSame($this->modelMock, $this->service->getModel());
    }

    #[Test]
    public function canCreateCallsModelCreateAndReturnsModel(): void
    {
        $data = ['foo' => 'bar'];
        $dto = new FakeDto($data);

        $this->modelMock
            ->expects($this->once())
            ->method('create')
            ->with($data)
            ->willReturn($this->modelMock);

        $result = $this->service->create($dto);
        $this->assertSame($this->modelMock, $result);
    }

    #[Test]
    public function canUpdateThrowsExceptionWhenModelNotFound(): void
    {
        $this->builderMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('Model with ID 1 not found.');

        $dto = new FakeDto(['foo' => 'bar']);
        $this->service->update(1, $dto);
    }

    #[Test]
    public function canUpdateUpdatesModelAndReturnsRefreshedModel(): void
    {
        $modelInstanceMock = $this->getMockBuilder(Model::class)
            ->onlyMethods(['update', 'refresh'])
            ->getMock();

        $this->builderMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($modelInstanceMock);

        $payload = ['foo' => 'bar'];

        $modelInstanceMock
            ->expects($this->once())
            ->method('update')
            ->with(['foo' => 'bar']);

        $modelInstanceMock
            ->expects($this->once())
            ->method('refresh')
            ->willReturnSelf();

        $dto = new FakeDto($payload);
        $result = $this->service->update(1, $dto);
        $this->assertSame($modelInstanceMock, $result);
    }

    #[Test]
    public function canDeleteReturnsFalseWhenModelNotFound(): void
    {
        $this->builderMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn(null);

        $result = $this->service->delete(1);
        $this->assertFalse($result);
    }

    #[Test]
    public function canDeleteDeletesModelAndReturnsTrue(): void
    {
        $modelInstanceMock = $this->getMockBuilder(Model::class)
            ->onlyMethods(['delete'])
            ->getMock();

        $this->builderMock
            ->expects($this->once())
            ->method('find')
            ->with(1)
            ->willReturn($modelInstanceMock);

        $modelInstanceMock
            ->expects($this->once())
            ->method('delete')
            ->willReturn(true);

        $result = $this->service->delete(1);
        $this->assertTrue($result);
    }

    protected function setUp(): void
    {
        parent::setUp();

        $this->builderMock = $this->getMockBuilder(Builder::class)
            ->onlyMethods(['create', 'find'])
            ->disableOriginalConstructor()
            ->getMock();

        $this->modelMock = $this->getMockBuilder(FakeModel::class)
            ->onlyMethods(['newQuery', 'create'])
            ->getMock();

        $this->modelMock
            ->method('newQuery')
            ->willReturn($this->builderMock);

        $this->service = $this->getMockBuilder(BaseService::class)
            ->setConstructorArgs([$this->modelMock])
            ->onlyMethods(['getUser', 'getModelClass'])
            ->getMock();

        $userMock = $this->createMock(User::class);
        $this->service->method('getUser')->willReturn($userMock);

        $this->service->method('getModelClass')->willReturn(User::class);

        Gate::shouldReceive('forUser')
            ->with($userMock)
            ->andReturnSelf();

        Gate::shouldReceive('authorize')
            ->andReturnTrue();
    }
}
