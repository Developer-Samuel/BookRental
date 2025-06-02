<?php

declare(strict_types=1);

namespace App\Http\Responders;

use Illuminate\Http\JsonResponse;

use App\Core\Traits\HasModelKey;

class JsonResponder
{
    use HasModelKey;

    /**
     * Response message.
     *
     * @param int $statusCode
     * @param string|null $message
     * @param object|null $modelInstance
     * @param mixed $data
     * @return JsonResponse
    */
    public static function response(
        int $statusCode,
        ?string $message = null,
        ?object $modelInstance = null,
        mixed $data = null
    ): JsonResponse {
        $response = [];

        if ($message !== null) {
            $response['message'] = $message;
        }

        $modelKey = self::getModelKey($modelInstance);
        if ($modelKey !== null && $data !== null) {
            $response[$modelKey] = $data;
        }

        return response()->json($response, $statusCode);
    }
}
