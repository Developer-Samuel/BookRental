<?php

declare(strict_types=1);

namespace App\Core\Abstracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;

use App\Core\Abstracts\Crud\AbstractCrudService;
use App\Core\Traits\WithAuthUser;
use App\Contracts\DTO\DataTransferObjectInterface;
use App\Contracts\Abstracts\BaseServiceContract;

use App\Models\User\User;

abstract class BaseService extends AbstractCrudService implements BaseServiceContract
{
    use WithAuthUser;

    protected Model $model;

    /**
     * Bind model instance
     *
     * @param Model $model
    */
    public function __construct(?Model $model = null)
    {
        $this->model = $model ?? app($this->getModelClass());
    }

    /**
     * Get the underlying Eloquent model instance.
     *
     * @return Model
    */
    public function getModel(): Model
    {
        return $this->model;
    }

    /**
     * @param DataTransferObjectInterface $dto
     * @return Model
    */
    public function create(DataTransferObjectInterface $dto): Model
    {
        /** @var User $user */
        $user = $this->getUser();

        Gate::forUser($user)->authorize('create', get_class($this->model));

        return $this->model->create($dto->toArray());
    }

    /**
     * @param int $recordId
     * @param DataTransferObjectInterface $dto
     * @return Model
    */
    public function update(int $recordId, DataTransferObjectInterface $dto): Model
    {
        $model = $this->model->find($recordId);

        if (!$model) {
            throw new \InvalidArgumentException("Model with ID {$recordId} not found.");
        }

        $user = $this->getUser();

        Gate::forUser($user)->authorize('update', $model);

        $model->update($dto->toArray());
        return $model->refresh();
    }

    /**
     * @param int $recordId
     * @return bool
    */
    public function delete(int $recordId): bool
    {
        $model = $this->model->find($recordId);

        if (!$model) {
            return false;
        }

        $user = $this->getUser();

        Gate::forUser($user)->authorize('delete', $model);

        return $model->delete();
    }
}
