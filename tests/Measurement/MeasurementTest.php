<?php

namespace Sundata\Utilities\Test\Measurement;

use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Test\Measurement\Energy;
use Sundata\Utilities\Test\Measurement\FormattedMeasurement;

class MeasurementTest extends TestCase
{
    function testSomething()
    {
        $energy = Energy::fromKwh(1000);
        $this->assertInstanceOf(FormattedMeasurement::class, $energy->format());
    }

}