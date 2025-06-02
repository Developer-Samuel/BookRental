<?php

declare(strict_types=1);

namespace App\Services\Common;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

final class ErrorLogger
{
    /**
     * @param Request $request
     * @param \Throwable $exception
     * @param string $method
     * @return void
    */
    public function report(Request $request, \Throwable $exception, string $method): void
    {
        Log::error('Error in ' . $method . ': ' . $exception->getMessage(), [
            'exception' => $exception,
            'request'   => $request->all(),
        ]);
    }
}
