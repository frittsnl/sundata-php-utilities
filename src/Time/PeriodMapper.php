<?php


namespace Sundata\Utilities\Time;


class PeriodMapper
{
    const MAP =
        [ // @formatter:off
            'year'  => ['1y', 365 * 24 * 60 * 60],
            'month' => ['1m',  30 * 24 * 60 * 60],
            'week'  => ['1w',   7 * 24 * 60 * 60],
            'day'   => ['1d',       24 * 60 * 60],
            'hour'  => ['1h',            60 * 60]
        ]; // @formatter:on

    public static function getInfluxPeriod($periodType): string
    {
        return self::MAP[$periodType][0];
    }

    public static function getDurationInSeconds($periodType): int
    {
        return self::MAP[$periodType][1];
    }

    public static function getAvailablePeriodTypes(): array
    {
        return array_keys(self::MAP);
    }
}
