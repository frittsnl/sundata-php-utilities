<?php


namespace Sundata\Utilities\Time;


use Carbon\CarbonImmutable;

class NativeTimeService implements TimeService
{
    function now(): CarbonImmutable
    {
        return CarbonImmutable::now();
    }
}