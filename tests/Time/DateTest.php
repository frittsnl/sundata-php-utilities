<?php

namespace Sundata\Utilities\Test\Time;

use InvalidArgumentException;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Time\Date;

class DateTest extends TestCase
{
    function testInvalidDateFormatShouldFail()
    {
        $this->expectException(InvalidArgumentException::class);
        Date::of('22-02-22');
    }

    function testCantConvertedToCarbonWithoutTimezone()
    {
        $this->expectException(InvalidArgumentException::class);
        Date::of('2021-01-01')->asCarbonImmutable();
    }

    function testCantHaveWeirdTimezone()
    {
        $this->expectException(InvalidArgumentException::class);
        Date::of('2021-01-01', 'muhlocaltime');
    }

    function testConvertToCarbon()
    {
        $date = Date::of('2021-01-01', 'Europe/Amsterdam');
        $carbon = $date->asCarbonImmutable();
        $this->assertEquals('2021-01-01T00:00:00+01:00', $carbon->toRfc3339String());
    }

    function testAddDays()
    {
        $date = Date::of('2021-01-01', 'Europe/Amsterdam');
        $dateADayLater = $date->addDays(1);
        $this->assertEquals('2021-01-02', $dateADayLater->toDateString());
    }

    function testAddDaysLeaveOriginalUnChanged()
    {
        $date = Date::of('2021-01-01', 'UTC');
        $date->addDays(1);
        $this->assertEquals('2021-01-01', $date->toDateString());
    }

    function testAddDaysCanBeNegative()
    {
        $this->assertEquals(
            '2020-12-30',
            Date::of('2021-01-01')
                ->addDays(-2)
                ->toDateString()
        );
    }

    function testAddDaysCanBeZero()
    {
        $this->assertEquals(
            '2021-02-02',
            Date::of('2021-02-02')
                ->addDays(-0)
                ->toDateString()
        );
    }
}
