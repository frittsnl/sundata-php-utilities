<?php

namespace Sundata\Utilities\Measurement;

class Energy implements Measurement
{
    private float $wattHour;
    public int $precision = 2;

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

    public function asTwh(): float
    {
        return $this->wattHour / 1E6;
    }

    public function format(): FormattedMeasurement
    {
        if ($this->wattHour >= 1E13) {
            return new FormattedMeasurement(
                round($this->asTwh(), $this->getPrecision()),
                'TWh'
            );
        }
        if ($this->wattHour >= 1E10) {
            return new FormattedMeasurement(
                round($this->asMwh(), $this->getPrecision()),
                'GWh'
            );
        }
        if ($this->wattHour >= 1E7) {
            return new FormattedMeasurement(
                round($this->asMwh(), $this->getPrecision()),
                'MWh'
            );
        }
        if ($this->wattHour >= 1E4) {
            return new FormattedMeasurement(
                round($this->asKwh(), $this->getPrecision()),
                'kWh'
            );
        }
        return new FormattedMeasurement(
            round($this->asWh(), $this->getPrecision()),
            'Wh'
        );
    }

    public function __toString(): string
    {
        return $this->format()->__toString();
    }

    public function asFloat(): float
    {
        return $this->wattHour;
    }

    public function setPrecision(int $precision): void
    {
        $this->precision = $precision;
    }

    public function getPrecision(): int
    {
        return $this->precision;
    }
}
