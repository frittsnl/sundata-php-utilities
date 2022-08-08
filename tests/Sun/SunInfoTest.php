<?php

namespace Sundata\Utilities\Test\Sun;

use Sundata\Utilities\Sun\SunInfo;
use Sundata\Utilities\Time\Date;
use PHPUnit\Framework\TestCase;

class SunInfoTest extends TestCase
{

    function test()
    {
        $lat = 52.0532538;
        $lon = 5.3180957;
        $date = Date::of('2022-08-08', 'Europe/Amsterdam');

        $sunInfo = SunInfo::of(
            $lat, $lon, $date
        );

        $this->assertEquals(
            '2022-08-07T06:08:05+02:00',
            $sunInfo->sunrise()->toRfc3339String()
        );
        $this->assertEquals(
            '2022-08-07T21:20:57+02:00',
            $sunInfo->sunset()->toRfc3339String()
        );
    }
}
