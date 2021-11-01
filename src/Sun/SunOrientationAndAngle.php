<?php

namespace Sundata\Utilities\Sun;

class SunOrientationAndAngle
{
    public $orientation;
    public $angle;

    function __construct($orientation, $angle)
    {
        $this->orientation = (int)$orientation;
        $this->angle = (int)$angle;
    }
}
