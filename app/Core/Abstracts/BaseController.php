<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

use App\Core\Abstracts\Crud\AbstractCrudController;
use App\Core\Helpers\IdDataExtractor;
use App\Core\Traits\HandlesSafeExecution;
use App\Core\Traits\ValidatesRequestTrait;

use App\Http\Responders\JsonResponder;
use App\Services\Common\ErrorLogger;

use App\Contracts\DTO\DataTransferObjectInterface;

abstract class BaseController extends AbstractCrudController
{
    use HandlesSafeExecution, ValidatesRequestTrait;

    /**
     * @param ErrorLogger $errorLogger
    */
    public function __construct(
        private readonly ErrorLogger $errorLogger
    ) {}

    /**
     * @return InertiaResponse
    */
    public function index(): InertiaResponse
    {
        $data = $this->getIndexViewData();

        return Inertia::render($data['view'], $data['props']);
    }

    /**
     * @return InertiaResponse
    */
    public function create(): InertiaResponse
    {
        $data = $this->getCreateViewData();

        return Inertia::render($data['view'], $data['props']);
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function store(Request $request): JsonResponse
    {
        return $this->safeExecute(function () use ($request) {
            $validatedData = $this->handleValidation($request, $this->getFormRequestClass());
            $dto = $this->createDTO($validatedData);

            $service = $this->service();

            if (!$service) {
                return JsonResponder::response(
                    500,
                    'Service not available.',
                    null,
                    null
                );
            }

            $model = $service->create($dto);

            if (!$model) {
                return JsonResponder::response(
                    400,
                    class_basename($service->getModel()) . ' could not be created.',
                    $service->getModel(),
                    $model
                );
            }

            return JsonResponder::response(
                200,
                class_basename($service->getModel()) . ' created successfully.',
                $service->getModel(),
                $model
            );
        });
    }

    /**
     * @param int $recordId
     * @return InertiaResponse|RedirectResponse
    */
    public function edit(int $recordId): InertiaResponse|RedirectResponse
    {
        $model = $this->repository()->find($recordId);

        if (!$model) {
            return redirect()->back();
        }

        $data = $this->getEditViewData($model);

        return Inertia::render(
            $data['view'],
            array_merge($data['props'], [
                'model' => $model,
            ])
        );
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function update(Request $request): JsonResponse
    {
        return $this->safeExecute(function () use ($request) {
            $validatedData = $this->handleValidation($request, $this->getUpdateFormRequestClass());

            [$recordId, $data] = IdDataExtractor::extract($validatedData);

            $dto = $this->createDTO($data);

            $service = $this->service();

            if (!$service) {
                return JsonResponder::response(
                    500,
                    'Service not available.',
                    null,
                    null
                );
            }

            $model = $service->update($recordId, $dto);

            return JsonResponder::response(
                200,
                class_basename($service->getModel()) . ' updated successfully.',
                $service->getModel(),
                $model
            );
        });
    }

    /**
     * @param Request $request
     * @return JsonResponse
    */
    public function destroy(Request $request): JsonResponse
    {
        return $this->safeExecute(function () use ($request) {
            $recordId = $request->input('id');
            $service = $this->service();

            $model = false;

            if ($service) {
                $model = $service->delete($recordId);
            }

            return JsonResponder::response(
                200,
                class_basename($service->getModel()) . ' deleted successfully.',
                $service->getModel(),
                $model
            );
        });
    }

    /**
     * @param array $data
     * @return DataTransferObjectInterface
    */
    protected function createDTO(array $data): DataTransferObjectInterface
    {
        $dtoClass = $this->getDTOClass();

        if (method_exists($dtoClass, 'fromArray')) {
            return $dtoClass::fromArray($data);
        }

        return new $dtoClass($data);
    }
}
