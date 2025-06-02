<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Carbon\Carbon;

final class DateFormatter
{
    /**
     * @param string|\DateTimeInterface|null $date
     * @return string|null
    */
    public static function format(string|\DateTimeInterface|null $date): ?string
    {
        if (!$date) {
            return null;
        }

        $carbonDate = Carbon::parse($date);

        return $carbonDate->format('d.m.Y');
    }
}
