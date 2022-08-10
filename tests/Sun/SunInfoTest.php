<?php

namespace Sundata\Utilities\Test\Sun;

use Sundata\Utilities\Sun\SunInfo;
use Sundata\Utilities\Time\Date;
use PHPUnit\Framework\TestCase;

class SunInfoTest extends TestCase
{
    function testSunset()
    {
        $lat = 52.0532538;
        $lon = 5.3180957;
        $date = Date::of('2022-08-08', 'Europe/Amsterdam');

        $sunInfo = SunInfo::of($lat, $lon, $date);

        // php7.x vs php8.x gives slightly different results
        $this->assertTrue(in_array(
            $sunInfo->sunset()->toRfc3339String(),
            ['2022-08-08T21:19:05+02:00', '2022-08-08T21:17:15+02:00']
        ));
    }

    function testSunrise()
    {
        $lat = 52.0532538;
        $lon = 5.3180957;
        $date = Date::of('2022-08-08', 'Europe/Amsterdam');

        $sunInfo = SunInfo::of($lat, $lon, $date);

        // php7.x vs php8.x gives slightly different results
        $this->assertTrue(in_array(
            $sunInfo->sunrise()->toRfc3339String(),
            ['2022-08-08T06:09:41+02:00', '2022-08-08T06:11:32+02:00']
        ));
    }
}
