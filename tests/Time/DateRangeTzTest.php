<?php

namespace Sundata\Utilities\Test\Time;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Time\DateRangeTz;
use Sundata\Utilities\Time\DateTz;

class DateRangeTzTest extends TestCase
{
    const DEFAULT_TZ = 'Europe/Amsterdam';

    function testBasic()
    {
        $dateRange = DateRangeTz::ofStrings(
            '2021-01-03',
            '2021-01-13',
            self::DEFAULT_TZ,
        );
        $this->assertEquals(10, $dateRange->nrDays());

        $dates = $dateRange->dates();
        $this->assertEquals(DateTz::of('2021-01-03', self::DEFAULT_TZ), $dates[0]);
        $this->assertEquals(DateTz::of('2021-01-12', self::DEFAULT_TZ), $dates[9]);
    }

    function testWithDates()
    {
        $dateRange = DateRangeTz::of(
            DateTz::of('2022-02-02', 'Europe/Amsterdam'),
            DateTz::of('2022-02-02', 'Europe/Amsterdam')
        );

        $this->assertEquals(0, $dateRange->nrDays());
        $this->assertEmpty($dateRange->dates());
    }

    function testWithBadDates()
    {
        $this->expectException(InvalidArgumentException::class);
        DateRangeTz::ofStrings(
            '2021-01-01',
            '2019-01-01',
            self::DEFAULT_TZ,
        );
    }

    function testWithBadTimezones()
    {
        $this->expectException(InvalidArgumentException::class);
        DateRangeTz::of(
            DateTz::of('2022-02-02', 'Europe/Amsterdam'),
            DateTz::of('2022-02-12', 'Europe/London')
        );
    }

    function testToString()
    {
        $dateRange = DateRangeTz::ofStrings(
            '2021-01-03',
            '2021-01-13',
            self::DEFAULT_TZ,
        );
        $this->assertEquals(
            'DateRangeTz: 2021-01-03 to 2021-01-13@Europe/Amsterdam',
            $dateRange->toString()
        );
    }
}
