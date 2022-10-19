<?php

namespace Sundata\Utilities\Test\Measurement;

use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Measurement\Energy;
use Sundata\Utilities\Measurement\FormattedMeasurement;

class EnergyTest extends TestCase
{
    function testFormatReturnsTheRightClass()
    {
        $energy = Energy::fromKwh(1000);
        $this->assertInstanceOf(FormattedMeasurement::class, $energy->format());
    }

    public function formatDataProvider(): array
    {
        return [
            [1, 'Wh'],
            [1000, 'kWh'],
            [10000, 'MWh'],
            [100000, 'MWh'],
            [1000000, 'MWh'],
            [10000000, 'GWh'],
            [100000000, 'GWh'],
            [1000000000, 'GWh'],
            [10000000000, 'TWh'],
            [10000000000000000000000, 'TWh'],
            [999999999999999999999999999999999999, 'TWh'],
        ];
    }

    /** @dataProvider formatDataProvider */
    public function testItFormatsToTheRightUnit($inputKwh, $expectedUnit)
    {
        $energy = Energy::fromKwh($inputKwh);
        $formattedMeasurement = $energy->format();
        $this->assertEquals($expectedUnit, $formattedMeasurement->unit);
    }

    public function testFormatsToTheRightValueAndUnitDataProvider(): array
    {
        return [
            [54321, '54.32 MWh'],
            [0.9475, '947.5 Wh'],
            [1111.1, '1111.1 kWh'],
            [22.2222, '22.22 kWh'],
            [333.3333, '333.33 kWh'],
            [4444.4444, '4444.44 kWh'],
            [55555.55555, '55.56 MWh'],
        ];
    }

    /** @dataProvider testFormatsToTheRightValueAndUnitDataProvider */
    public function testItFormatsToTheRightValueAndUnit($inputKwh, $expectedString)
    {
        $energy = Energy::fromKwh($inputKwh);
        $this->assertEquals($expectedString, $energy->__toString());
    }

    public function testSettingPrecisionWorks()
    {
        $energy = Energy::fromKwh(21234567895);
        $this->assertEquals(21234567.9, $energy->format()->value);
        $energy->setPrecision(3);
        $this->assertEquals(21234567.895, $energy->format()->value);
        $this->assertEquals('21234567.895 TWh', $energy->format()->__toString());
    }
}