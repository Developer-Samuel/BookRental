<?php

declare(strict_types=1);

namespace App\Core\Traits;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Services\Common\ErrorLogger;

trait HandlesSafeExecution
{
    protected ErrorLogger $logger;

    /**
     * @param callable $callback
     * @return JsonResponse|RedirectResponse|Response
    */
    protected function safeExecute(callable $callback): JsonResponse|RedirectResponse|Response
    {
        try {
            $result = $callback();

            return $this->handleResult($result);
        } catch (ValidationException $exception) {
            return $this->handleValidationException($exception);
        } catch (HttpResponseException $exception) {
            return $this->handleHttpResponseException($exception);
        } catch (\Exception $exception) {
            return $this->handleGeneralException($exception);
        }
    }

    /**
     * @param mixed $result
     * @return JsonResponse|RedirectResponse|Response
    */
    protected function handleResult(mixed $result): JsonResponse|RedirectResponse|Response
    {
        if ($result instanceof RedirectResponse) {
            return response()->json([
                'redirect' => $result->getTargetUrl(),
            ]);
        }

        if ($result instanceof JsonResponse || $result instanceof Response) {
            return $result;
        }

        return response()->json([
            'error' => 'Unexpected response type',
        ], 500);
    }

    /**
     * @param ValidationException $exception
     * @return JsonResponse
    */
    protected function handleValidationException(ValidationException $exception): JsonResponse
    {
        return response()->json([
            'message' => 'Validation failed',
            'errors'  => $exception->errors(),
        ], 422);
    }

    /**
     * @param HttpResponseException $exception
     * @return JsonResponse
    */
    protected function handleHttpResponseException(HttpResponseException $exception): JsonResponse
    {
        $response = $exception->getResponse();

        if ($response instanceof JsonResponse) {
            return $response;
        }

        if (isset($this->errorLogger)) {
            $this->errorLogger->report(request(), $exception, __METHOD__);
        }

        return response()->json([
            'error' => $response->getContent(),
        ], $response->getStatusCode());
    }

    /**
     * @param \Exception $exception
     * @return JsonResponse
    */
    protected function handleGeneralException(\Exception $exception): JsonResponse
    {
        if (isset($this->errorLogger)) {
            $this->errorLogger->report(request(), $exception, __METHOD__);
        }

        return response()->json(['error' => $exception->getMessage()], 500);
    }
}
