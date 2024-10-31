<?php

namespace Sundata\Utilities\Test\Measurement;

use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Measurement\Irradiance;

class ExposureMeasurementTest extends TestCase
{
    function testExposureOfGetValueFunction()
    {
        $this->expectError();
        // please ignore any errors from your editor
        Irradiance::fromJcm2(1)->getValue();
    }

    function testExposureOfFromValueFunction()
    {
        $this->expectError();
        Irradiance::fromValue(1);
    }
}
