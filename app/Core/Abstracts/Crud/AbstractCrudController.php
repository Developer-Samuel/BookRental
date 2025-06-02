<?php

declare(strict_types=1);

namespace App\Core\Abstracts\Crud;

abstract class AbstractCrudController
{
    /**
     * Returns the service instance related to the controller.
     *
     * @return mixed
    */
    abstract protected function service();

    /**
     * Returns the repository instance related to the controller.
     *
     * @return mixed
    */
    abstract protected function repository();

    /**
     * Returns data needed for the index view.
     *
     * @return array
    */
    abstract protected function getIndexViewData(): array;

    /**
     * Returns data needed for the create view.
     *
     * @return array
    */
    abstract protected function getCreateViewData(): array;

    /**
     * Returns data needed for the edit view, given the model.
     *
     * @param object $model
     * @return array
    */
    abstract protected function getEditViewData(object $model): array;

    /**
     * Returns the fully qualified class name of the Form Request class.
     *
     * @return string
    */
    abstract protected function getFormRequestClass(): string;

    /**
     * Return the Data Transfer Object class to be used.
     *
     * @return string
    */
    abstract protected function getDTOClass(): string;
}
