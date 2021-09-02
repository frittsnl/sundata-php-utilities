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
            new Period(
                CarbonImmutable::parse('2019-01-01'),
                CarbonImmutable::parse('2019-12-31')
            ),
            386585.1429,
            100.0
        ];

        yield 'Full leap year is the same value as regular year' => [
            new Period(
                CarbonImmutable::parse('2020-01-01'),
                CarbonImmutable::parse('2020-12-31')
            ),
            386585.1429,
            100.0
        ];

        yield 'Only August' => [
            new Period(
                CarbonImmutable::parse('2020-08-01'),
                CarbonImmutable::parse('2020-08-31')
            ),
            46749.285799999954,
            12.1
        ];

        yield '2 full years' => [
            new Period(
                CarbonImmutable::parse('2019-01-01'),
                CarbonImmutable::parse('2020-12-31')
            ),
            386585.1429 * 2,
            200.0
        ];

    }

    /** @dataProvider RadiationInPeriodDataProvider */
    public function testItReturnsTheRadiationForAPeriod(
        Period $period,
        $expectedRadiation,
        $expectedPercentageOf7YAverage
    ){
        $this->assertSame($expectedRadiation, RadiationInPeriod::getAvgRadiation($period));
        $this->assertSame($expectedPercentageOf7YAverage, RadiationInPeriod::getRadiationPercentageOf7YAverage($period));
    }
}
