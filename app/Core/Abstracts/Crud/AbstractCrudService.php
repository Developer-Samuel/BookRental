<?php

declare(strict_types=1);

namespace App\Core\Abstracts\Crud;

abstract class AbstractCrudService
{
    /**
     * Return the model class name associated with this service.
     *
     * @return string
    */
    abstract protected function getModelClass(): string;
}
