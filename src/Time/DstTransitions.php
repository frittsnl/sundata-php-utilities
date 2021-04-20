<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonImmutable;
use RuntimeException;

class DstTransitions // in Europe
{
    static function getDstStart(int $year): CarbonImmutable
    {
        if ($year < 2002) throw new RuntimeException('Years before 2002 are unsupported');
        return self::getLastSundayOfMonth($year, 3);
    }

    static function getDstEnd(int $year): CarbonImmutable
    {
        if ($year < 2002) throw new RuntimeException('Years before 2002 are unsupported');
        return self::getLastSundayOfMonth($year, 10);
    }

    static private function getLastSundayOfMonth(int $year, int $month): CarbonImmutable
    {
        $date = CarbonImmutable::create($year, $month, 31, 1, 0, 0, 'UTC');
        if ($date->dayOfWeekIso !== 7) {
            $date = $date->subDays($date->dayOfWeekIso);
        }
        return $date;
    }
}