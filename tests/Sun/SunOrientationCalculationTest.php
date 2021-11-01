<?php

namespace Sundata\Utilities\Test\Sun;

use Sundata\Utilities\Sun\SunOrientationCalculation;
use PHPUnit\Framework\TestCase;

class SunOrientationCalculationTest extends TestCase
{

    /**
     * This method is called before each test.
     */
    public function setUp(): void
    {
        parent::setUp();
    }

    /**
     * @group sun_orientation_calculation
     * @test
     */
    public function it_returns_the_sun_position_based_on_timezone()
    {

        $locations = json_decode(file_get_contents('./tests/Sun/data/ExpectedSunOrientationData.json'));

        foreach ($locations as $_location) {
            $sunOrientationCalculation = new SunOrientationCalculation($_location->date_time, $_location->timezone, $_location->latitude, $_location->longitude);
            $sunPosition = $sunOrientationCalculation->getSunPosition();
            $this->assertSame($sunPosition->orientation, $_location->expected_orientation);
            $this->assertSame($sunPosition->angle, $_location->expected_angle);
        }

    }

}
