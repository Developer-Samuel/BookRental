<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

final class SmartCache
{
    /**
     * @param string $key
     * @param int $seconds
     * @param \Closure $callback
     * @return mixed
    */
    public static function remember(string $key, int $seconds, \Closure $callback): mixed
    {
        if (config('cache.default') === 'redis') {
            try {
                $cached = Redis::get($key);

                if ($cached !== null) {
                    return unserialize($cached);
                }

                $value = $callback();

                Redis::setex($key, $seconds, serialize($value));

                return $value;
            } catch (\Exception $e) {
                Log::error("Redis error: " . $e->getMessage());
                return Cache::remember($key, $seconds, $callback);
            }
        }

        return Cache::remember($key, $seconds, $callback);
    }
}
