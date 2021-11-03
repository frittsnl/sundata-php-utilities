<?php

namespace Sundata\Utilities\Radiation;

use Sundata\Utilities\Sun\SunOrientationAndAngle;
use Sundata\Utilities\Sun\SunOrientationCalculation;

class MeterRadiation
{
    const TIMEZONE = 'CET';

    public function calculateIrradianceForDateTime(MeterRadiationRequest $request) {
        $sunPos = $this->getSolarPositionForDateTime($request);
        $irradiance =  $this->calculateSolarIrradiance($sunPos, $request);
        return $irradiance < 0 ? 0 : $irradiance;
    }

    public function getSolarPositionForDateTime(MeterRadiationRequest $request): SunOrientationAndAngle {
        $sunObject = new SunOrientationCalculation(
            $request->hour, self::TIMEZONE, $request->lat, $request->long);
        return $sunObject->getSunPosition();
    }

    public function calculateSolarIrradiance(SunOrientationAndAngle $sunPos, MeterRadiationRequest $request) {
        $sunAngleRad = deg2rad($sunPos->angle);
        $sunAzimuthRad = deg2rad($sunPos->orientation);
        $meterAngleRad = deg2rad($request->meterAngle);
        $meterAzimuthRad = deg2rad($request->meterOrientation);

        return $request->globalIrradiance *
            (cos($sunAngleRad) * sin($meterAngleRad) * cos($meterAzimuthRad - $sunAzimuthRad)
                + sin($sunAngleRad) * cos($meterAngleRad));
    }
}