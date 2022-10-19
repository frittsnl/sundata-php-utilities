<?php

namespace Sundata\Utilities\Test\Measurement;

use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Measurement\Weight;
use Sundata\Utilities\Measurement\FormattedMeasurement;

class WeightTest extends TestCase
{
    function testFormatReturnsTheRightClass()
    {
        $weight = Weight::fromKg(1000);
        $this->assertInstanceOf(FormattedMeasurement::class, $weight->format());
    }

    public function formatDataProvider(): array
    {
        return [
            [$kg = 1, 'g'],
            [$kg = 1000, 'kg'],
            [$kg = 10000, 't'],
            [$kg = 100000, 't'],
            [$kg = 1000000, 't'],
            [$kg = 10000000, 't'],
            [$kg = 100000000, 'Mt'],
            [$kg = 1000000000, 'Mt'],
            [$kg = 10000000000, 'Mt'],
            [$kg = 10000000000000000000000, 'Gt'],
            [$kg = 999999999999999999999999999999999999, 'Gt'],
        ];
    }

    /** @dataProvider formatDataProvider */
    public function testItFormatsToTheRightUnit($inputKg, $expectedUnit)
    {
        $weight = Weight::fromKg($inputKg);
        $formattedMeasurement = $weight->format();
        $this->assertEquals($expectedUnit, $formattedMeasurement->unit);
    }

    public function testItDoesTheRightCalculation()
    {
        $kg = 100000000000;
        $weight = Weight::fromKg($kg);
        $this->assertEquals($kg * 1000, $weight->asGr());
        $this->assertEquals($kg, $weight->asKg());
        $this->assertEquals($kg / 1000, $weight->asT());
        $this->assertEquals($kg / 1000 / 1000 / 1000, $weight->asMt());
        $this->assertEquals($kg / 1000 / 1000 / 1000 / 1000, $weight->asGt());
    }

    public function formatsToTheRightValueAndUnitDataProvider(): array
    {
        return [
            [5432, '5432 kg'],
            [0.9475, '947.5 g'],
            [1111.1, '1111.1 kg'],
            [55555.55555, '55.56 t'],
            [21234567, '21234.57 t'],
            [5555555555, '5.56 Mt'],
            [5555555555 * 1000, '5.56 Gt'],
        ];
    }

    /** @dataProvider formatsToTheRightValueAndUnitDataProvider */
    public function testItFormatsToTheRightValueAndUnit($inputKg, $expectedString)
    {
        $weight = Weight::fromKg($inputKg);
        $this->assertEquals($expectedString, $weight->__toString());
    }

    public function testSettingPrecisionWorks()
    {
        $weight = Weight::fromKg(21234567.1234);
        $this->assertEquals(21234.57, $weight->format()->value);
        $this->assertEquals('t', $weight->format()->unit);

        $this->assertEquals(21234.6, $weight->format(1)->value);
        $this->assertEquals('21234.6 t', $weight->format(1)->__toString());
        $this->assertEquals(21234.5671, $weight->format(4)->value);
        $this->assertEquals('21234.5671 t', $weight->format(4)->__toString());
    }
}