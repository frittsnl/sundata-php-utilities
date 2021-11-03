<?php

namespace Sundata\Utilities\Radiation;

use Sundata\Utilities\Sun\SunOrientationAndAngle;
use Sundata\Utilities\Sun\SunOrientationCalculation;

class MeterRadiation
{
    const TIMEZONE = 'CET';

    public function calculateIrradianceForDateTime(RadiationRequest $request) {
        $sunPos = $this->getSolarPositionForDateTime($request);
        return $this->calculateSolarIrradiance($sunPos, $request);
    }

    public function getSolarPositionForDateTime(RadiationRequest $request): SunOrientationAndAngle {
        $sunObject = new SunOrientationCalculation(
            $request->hour, self::TIMEZONE, $request->lat, $request->long);
        return $sunObject->getSunPosition();
    }

    public function calculateSolarIrradiance(SunOrientationAndAngle $sunPos, RadiationRequest $request) {
        $sunAngleRad = deg2rad($sunPos->angle);
        $sunAzimuthRad = deg2rad($sunPos->orientation);
        $meterAngleRad = deg2rad($request->meterAngle);
        $meterAzimuthRad = deg2rad($request->meterOrientation);

        return $request->globalIrradiance *
            (cos($sunAngleRad) * sin($meterAngleRad) * cos( - $sunAzimuthRad)
                + sin($sunAngleRad) * cos($meterAzimuthRad));
    }
}