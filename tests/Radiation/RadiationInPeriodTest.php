<?php

namespace Sundata\Utilities\Test\Radiation;

use Carbon\CarbonImmutable;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Radiation\RadiationInPeriod;
use Sundata\Utilities\Time\Period;

class RadiationInPeriodTest extends TestCase
{

    public function RadiationInPeriodDataProvider(): \Generator
    {
        yield 'Full year' => [
            '2019-01-01',
            '2019-12-31',
            386585.1429,
            100.0
        ];

        yield 'Full leap year is the same value as regular year' => [
            '2020-01-01',
            '2020-12-31',
            386585.1429,
            100.0
        ];

        yield 'Only August' => [
            '2020-08-01',
            '2020-08-31',
            46749.285799999954,
            12.1
        ];

        yield 'October to March (stepping into a new year)' => [
            '2019-10-01',
            '2020-03-31',
            83741.42865999995,
            21.7
        ];

        yield 'October 2018 to March 2020 (more than 1 year)' => [
            '2018-10-01',
            '2020-03-31',
            470492.57155999995,
            100.0 + 21.7
        ];

    }

    /** @dataProvider RadiationInPeriodDataProvider */
    public function testItReturnsTheRadiationForAPeriod(
        $start,
        $end,
        $expectedRadiation,
        $expectedPercentageOf7YAverage
    )
    {
        $period = new Period(CarbonImmutable::parse($start), CarbonImmutable::parse($end));
        $this->assertSame($expectedRadiation, RadiationInPeriod::getAvgRadiation($period));
        $this->assertSame($expectedPercentageOf7YAverage, RadiationInPeriod::getRadiationPercentageOf7YAverage($period));
    }
}
