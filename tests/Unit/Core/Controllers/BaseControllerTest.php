<?php

declare(strict_types=1);

namespace Tests\Unit\Core\Controllers;

use Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;
use Tests\Unit\Core\DTO\TestDTO;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Inertia\Response as InertiaResponse;

use App\Core\Abstracts\BaseController;

use App\Services\Common\ErrorLogger;

class BaseControllerTest extends TestCase
{
    #[Test]
    public function indexReturnsInertiaResponse()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function service() {}
            protected function repository() {}
            protected function getIndexViewData(): array
            {
                return [
                    'view'  => 'Dashboard',
                    'props' => ['message' => 'Welcome']
                ];
            }
            protected function getCreateViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getFormRequestClass(): string { return ''; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $response = $controller->index();
        $this->assertInstanceOf(InertiaResponse::class, $response);
    }

    #[Test]
    public function createReturnsInertiaResponse()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function service() {}
            protected function repository() {}
            protected function getCreateViewData(): array
            {
                return [
                    'view'  => 'CreateView',
                    'props' => ['data' => 'some data']
                ];
            }
            protected function getIndexViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getFormRequestClass(): string { return ''; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $response = $controller->create();
        $this->assertInstanceOf(InertiaResponse::class, $response);
    }

    #[Test]
    public function storeReturnsJsonResponseWhenSuccessful()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function service()
            {
                return new class {
                    public function create($data) { return (object) (['id' => 1] + (array) $data); }
                    public function getModel() { return new \stdClass(); }
                };
            }
            protected function getFormRequestClass(): string { return ''; }
            protected function handleValidation(Request $request, string $class): array
            {
                return ['name' => 'Test'];
            }
            protected function repository() {}
            protected function getIndexViewData(): array { return []; }
            protected function getCreateViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $request = Request::create('/store', 'POST', ['name' => 'Test']);
        $response = $controller->store($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('stdClass created successfully.', $response->getContent());
    }

    #[Test]
    public function editReturnsInertiaResponseIfModelFound()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function repository()
            {
                return new class {
                    public function find($id)
                    {
                        return (object) ['id' => $id, 'name' => 'test'];
                    }
                };
            }
            protected function getEditViewData(object $model): array
            {
                return [
                    'view'  => 'EditView',
                    'props' => ['extra' => 'value']
                ];
            }
            protected function service() {}
            protected function getIndexViewData(): array { return []; }
            protected function getCreateViewData(): array { return []; }
            protected function getFormRequestClass(): string { return ''; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $response = $controller->edit(1);
        $this->assertInstanceOf(InertiaResponse::class, $response);
    }

    #[Test]
    public function editReturnsInertiaResponseIfModelNotFound()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function repository()
            {
                return new class {
                    public function find($id)
                    {
                        return null;
                    }
                };
            }
            protected function service() {}
            protected function getIndexViewData(): array { return []; }
            protected function getCreateViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getFormRequestClass(): string { return ''; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $response = $controller->edit(999);
        $this->assertInstanceOf(RedirectResponse::class, $response);
    }

    #[Test]
    public function updateReturnsJsonResponse()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function service()
            {
                return new class {
                    public function update($id, $data) { return ['id' => $id, 'updated' => true] + (array) $data; }
                    public function getModel() { return new \stdClass(); }
                };
            }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function handleValidation(Request $request, string $class): array
            {
                return ['id' => 1, 'name' => 'UpdatedName'];
            }
            protected function repository() {}
            protected function getIndexViewData(): array { return []; }
            protected function getCreateViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $request = Request::create('/update', 'PUT', ['id' => 1, 'name' => 'UpdatedName']);
        $response = $controller->update($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('stdClass updated successfully.', $response->getContent());
    }

    #[Test]
    public function destroyReturnsJsonResponse()
    {
        $controller = new class(new ErrorLogger()) extends BaseController {
            protected function service()
            {
                return new class {
                    public function delete($id) { return true; }
                    public function getModel() { return new \stdClass(); }
                };
            }
            protected function repository() {}
            protected function getFormRequestClass(): string { return ''; }
            protected function getIndexViewData(): array { return []; }
            protected function getCreateViewData(): array { return []; }
            protected function getEditViewData(object $model): array { return []; }
            protected function getUpdateFormRequestClass(): string { return ''; }
            protected function getDTOClass(): string { return TestDTO::class; }
        };

        $request = Request::create('/destroy', 'DELETE', ['id' => 123]);
        $response = $controller->destroy($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('stdClass deleted successfully.', $response->getContent());
    }
}
