<?php

declare(strict_types=1);

namespace App\Contracts\DTO;

interface DataTransferObjectInterface
{
    /**
     * It returns an associative array, which it then pushes into Eloquent (Model::create, update).
     *
     * @return array
    */
    public function toArray(): array;
}
