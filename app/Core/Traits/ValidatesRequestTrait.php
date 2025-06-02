<?php

declare(strict_types=1);

namespace App\Core\Traits;

use Illuminate\Http\Request;

trait ValidatesRequestTrait
{
    /**
     * @param Request $request
     * @param string $formRequestClass
     * @return array
    */
    protected function handleValidation(Request $request, string $formRequestClass): array
    {
        $validatedRequest = app($formRequestClass);
        $validatedRequest->merge($request->all());
        return $validatedRequest->validated();
    }

    /**
     * @return string
    */
    protected function getUpdateFormRequestClass(): string
    {
        return $this->getFormRequestClass();
    }
}
