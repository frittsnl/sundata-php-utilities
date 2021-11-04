<?php

namespace Sundata\Utilities\Radiation;

use Carbon\CarbonImmutable;
use Sundata\Utilities\Sun\SunOrientationAndAngle;
use Sundata\Utilities\Sun\SunOrientationCalculation;

class MeterRadiation
{

    /**
     * Calculates the meter specific irradiance in W/m2 based on
     * the sun's position and global irradiance for a date time
     *
     * @return float as W/m2
     */
    public static function calculateIrradianceForDateTime(
        MeterFacts      $facts,
        CarbonImmutable $dateTime,
        float           $globalRadiation): float
    {
        $sunPos = self::getSolarPositionForDateTime($facts, $dateTime);
        $irradiance =  self::calculateSolarIrradiance($sunPos, $facts, $globalRadiation);
        return $irradiance < 0 ? 0 : $irradiance;
    }

    public static function getSolarPositionForDateTime(
        MeterFacts      $facts,
        CarbonImmutable $dateTime): SunOrientationAndAngle
    {
        $sunObject = new SunOrientationCalculation(
            $dateTime, $dateTime->getTimezone(), $facts->lat, $facts->long);
        return $sunObject->getSunPosition();
    }

    /**
     * Using the formula from
     * https://www.pveducation.org/pvcdrom/properties-of-sunlight/arbitrary-orientation-and-tilt
     */
    public static function calculateSolarIrradiance(
        SunOrientationAndAngle $sunPos,
        MeterFacts $facts,
        float $globalRadiation): float
    {
        $sunAngleRad = deg2rad($sunPos->angle);
        $sunAzimuthRad = deg2rad($sunPos->orientation);
        $meterAngleRad = deg2rad($facts->meterAngleInDegrees);
        $meterAzimuthRad = deg2rad($facts->meterOrientationInDegrees);

        return $globalRadiation *
            (cos($sunAngleRad) * sin($meterAngleRad) * cos($meterAzimuthRad - $sunAzimuthRad)
                + sin($sunAngleRad) * cos($meterAngleRad));
    }
}