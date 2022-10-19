<?php

namespace Sundata\Utilities\Measurement;

class Energy implements Measurement
{
    private float $wattHour;

    private function __construct(
        $wattHour
    ) {
        $this->wattHour = $wattHour;
    }

    public static function fromKwh(float $kwh): Energy
    {
        return new Energy($kwh * 1000);
    }

    public function asWh(): float
    {
        return $this->wattHour;
    }

    public function asKwh(): float
    {
        return $this->wattHour / 1E3;
    }

    public function asMwh(): float
    {
        return $this->wattHour / 1E6;
    }

    public function asGwh(): float
    {
        return $this->wattHour / 1E9;
    }

    public function asTwh(): float
    {
        return $this->wattHour / 1E12;
    }

    public function format(?int $precision = 2): FormattedMeasurement
    {
        if ($this->wattHour >= 1E13) {
            return new FormattedMeasurement(
                round($this->asTwh(), $precision),
                'TWh'
            );
        }
        if ($this->wattHour >= 1E10) {
            return new FormattedMeasurement(
                round($this->asGwh(), $precision),
                'GWh'
            );
        }
        if ($this->wattHour >= 1E7) {
            return new FormattedMeasurement(
                round($this->asMwh(), $precision),
                'MWh'
            );
        }
        if ($this->wattHour >= 1E4) {
            return new FormattedMeasurement(
                round($this->asKwh(), $precision),
                'kWh'
            );
        }
        return new FormattedMeasurement(
            round($this->asWh(), $precision),
            'Wh'
        );
    }

    public function __toString(): string
    {
        return $this->format()->__toString();
    }

}
