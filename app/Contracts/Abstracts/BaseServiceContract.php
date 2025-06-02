<?php

declare(strict_types=1);

namespace App\Contracts\Abstracts;

use Illuminate\Database\Eloquent\Model;

use App\Contracts\DTO\DataTransferObjectInterface;

interface BaseServiceContract
{
    /**
     * @param DataTransferObjectInterface $dto
     * @return Model
    */
    public function create(DataTransferObjectInterface $dto): Model;

    /**
     * @param int $recordId
     * @param DataTransferObjectInterface $dto
     * @return Model
    */
    public function update(int $recordId, DataTransferObjectInterface $dto): Model;

    /**
     * @param int $recordId
     * @return bool
    */
    public function delete(int $recordId): bool;
}
