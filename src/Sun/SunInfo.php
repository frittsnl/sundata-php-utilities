<?php

namespace Sundata\Utilities\Sun;

use Carbon\CarbonImmutable;
use Sundata\Utilities\Time\DateTz;

/**
 * Wrapper date_sun_info (php native)
 */
class SunInfo
{
    private $sunInfo;
    private $timezoneName;

    public function __construct(
        array  $sunInfo,
        string $timezoneName
    ) {
        $this->sunInfo = $sunInfo;
        $this->timezoneName = $timezoneName;
    }

    static function of(
        float $lat,
        float $lon,
        DateTz  $date
    ): SunInfo {
        $carbon = $date->asCarbonImmutable();
        return new SunInfo(
            date_sun_info(
                strtotime($date->toDateString()),
                $lat,
                $lon
            ),
            $carbon->timezoneName
        );
    }

    /** For when needing a general idea of the SunInfo in the Netherlands. */
    static function ofUtrecht(
        DateTz $date
    ): SunInfo {
        return SunInfo::of(52.0906894, 5.1213124, $date); //Domtoren
    }


    function sunrise(): CarbonImmutable
    {
        return $this->parseKeyAsCarbonImmutable('sunrise');
    }

    function sunset(): CarbonImmutable
    {
        return $this->parseKeyAsCarbonImmutable('sunset');
    }

    private function parseKeyAsCarbonImmutable(string $key): CarbonImmutable
    {
        return CarbonImmutable::createFromTimestamp(
            $this->sunInfo[$key],
            $this->timezoneName
        );
    }
}
