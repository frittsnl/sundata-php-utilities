<?php

namespace Sundata\Utilities\Radiation;

class RadiationRequest
{
    public string  $lat;
    public string  $long;
    public string  $hour;
    public int     $meterAngle;
    public int     $meterOrientation;
    public int     $globalIrradiance;

    public function __construct(
        string  $lat,
        string  $long,
        string  $hour,
        int     $meterAngle,
        int     $meterOrientation,
        int     $globalIrradiance)
    {
        $this->lat = $lat;
        $this->long = $long;
        $this->hour = $hour;
        $this->meterAngle = $meterAngle;
        $this->meterOrientation = $meterOrientation;
        $this->globalIrradiance = $globalIrradiance;
    }
}