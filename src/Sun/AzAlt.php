<?php

namespace Sundata\Utilities\Sun;

class AzAlt
{
    public $azimuth;
    public $altitude;

    function __construct($az, $alt)
    {
        $this->azimuth = $az;
        $this->altitude = $alt;
    }
}