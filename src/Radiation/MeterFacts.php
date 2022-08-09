<?php

namespace Sundata\Utilities\Radiation;

class MeterFacts
{
    public $lat;
    public $long;
    public $meterAngleInDegrees;
    public $meterOrientationInDegrees;

    /**
     * @param float $lat latitude in GPS decimals (DD.dddddd)
     * @param float $long longitude in GPS decimals (DD.dddddd)
     * @param int $meterAngleInDegrees measured as 0 horizontal, 90 being vertical
     * @param int $meterOrientationInDegrees measured as 0 being North, 180 being South
     */
    public function __construct(
        float $lat,
        float $long,
        int   $meterAngleInDegrees,
        int   $meterOrientationInDegrees
    ) {
        $this->lat = $lat;
        $this->long = $long;
        $this->meterAngleInDegrees = $meterAngleInDegrees;
        $this->meterOrientationInDegrees = $meterOrientationInDegrees;
    }
}
