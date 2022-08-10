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

        $sunInfo = SunInfo::of(
            $lat, $lon, $date
        );


        $this->assertEquals(
            '2022-08-08T21:19:05+02:00',
            $sunInfo->sunset()->toRfc3339String()
        );

//        $this->assertTrue(in_array(
//            $sunInfo->sunset()->toRfc3339String(),
//            ['2022-08-07T21:20:57+02:00', '2022-08-07T21:19:06+02:00']
//        ));
    }
    function testSunrise()
    {
        $lat = 52.0532538;
        $lon = 5.3180957;
        $date = Date::of('2022-08-08', 'Europe/Amsterdam');

        $sunInfo = SunInfo::of(
            $lat, $lon, $date
        );

        $this->assertEquals(
            '2022-08-08T06:09:41+02:00',
            $sunInfo->sunrise()->toRfc3339String()
        );
        //        $this->assertTrue(in_array(
//            $sunInfo->sunrise()->toRfc3339String(),
//            ['2022-08-07T06:08:05+02:00', '2022-08-07T06:09:56+02:00']
//        ));
    }
}
