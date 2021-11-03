<?php

namespace Sundata\Utilities\Test\Radiation;

use Generator;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Radiation\MeterRadiation;
use Sundata\Utilities\Radiation\MeterRadiationRequest;

class MeterRadiationTest extends TestCase
{
    public function MeterRadiationDataProvider(): Generator
    {
        yield 'South facing 80 degrees' => [
            new MeterRadiationRequest(
                '52.1009166',
                '5.36237110',
                '2021-11-01 12:00:00',
                80,
                180,
                111
            ),
            107.6038497322];

        yield 'East facing 80 degrees' => [
            new MeterRadiationRequest(
                '52.1009166',
                '5.36237110',
                '2021-11-01 12:00:00',
                80,
                90,
                111
            ),
            18.049368565163];

        yield 'West facing 40 degrees' => [
            new MeterRadiationRequest(
                '52.1009166',
                '5.36237110',
                '2021-11-01 12:00:00',
                40,
                270,
                111
            ),
            26.35906520119];
    }

    /** @dataProvider MeterRadiationDataProvider */
    public function testItReturnsMeterIrradiance(
        MeterRadiationRequest $request,
        $expectedIrradiance
    )
    {
        $meterRadiation = new MeterRadiation();
        $rad = $meterRadiation->calculateIrradianceForDateTime($request);
        self::assertEquals($expectedIrradiance, $rad);
    }
}
