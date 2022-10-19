<?php

namespace Sundata\Utilities\Test\Measurement;

use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Measurement\FormattedMeasurement;

class FormattedMeasurementTest extends TestCase
{
    public function test(){
        $formattedMeasurement = new FormattedMeasurement(1000, 'kWh');
        $this->assertEquals('1000 kWh', $formattedMeasurement->__toString());
        $this->assertEquals(1000, $formattedMeasurement->value);
        $this->assertEquals('kWh', $formattedMeasurement->unit);
    }
}
