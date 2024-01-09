<?php

namespace Sundata\Utilities\Test\Time;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Time\Date;
use Sundata\Utilities\Time\DateRange;

class DateRangeTest extends TestCase
{
    function testWithoutTimezone()
    {
        $dateRange = DateRange::ofStrings(
            '2021-01-03',
            '2021-01-13',
        );
        $this->assertEquals(10, $dateRange->nrDays());

        $dates = $dateRange->dates();
        $this->assertEquals(Date::of('2021-01-03'), $dates[0]);
        $this->assertEquals(Date::of('2021-01-12'), $dates[9]);
    }

    function testWithDates()
    {
        $dateRange = DateRange::of(
            Date::of('2022-02-02'),
            Date::of('2022-02-02')
        );

        $this->assertEquals(0, $dateRange->nrDays());
        $this->assertEmpty($dateRange->dates());
    }

    function testWithBadDates()
    {
        $this->expectException(InvalidArgumentException::class);
        DateRange::ofStrings(
            '2021-01-01',
            '2019-01-01'
        );
    }

    function testToString()
    {
        $dateRange = DateRange::ofStrings(
            '2021-01-03',
            '2021-01-13',
        );
        $this->assertEquals(
            'DateRange: 2021-01-03 to 2021-01-13',
            $dateRange->toString()
        );
    }
}
