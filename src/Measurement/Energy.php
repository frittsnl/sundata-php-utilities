<?php

namespace Sundata\Utilities\Measurement;

class Energy extends Measurement
{
    private float $wattHour;

    private function __construct(
        $wattHour
    ) {
        $this->wattHour = $wattHour;
    }

    public static function fromWh(float $wh): Energy
    {
        return new Energy($wh);
    }

    public static function fromKwh(float $kWh): Energy
    {
        return new Energy($kWh * 1E3);
    }

    public static function fromMwh(float $mWh): Energy
    {
        return new Energy($mWh * 1E6);
    }

    public static function fromGwh(float $gWh): Energy
    {
        return new Energy($gWh * 1E9);
    }

    public static function fromTwh(float $tWh): Energy
    {
        return new Energy($tWh * 1E12);
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

    public function format(int $precision = 2): FormattedMeasurement
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

    protected function getValue()
    {
        return $this->wattHour;
    }

    static protected function fromValue($value): self
    {
        return Energy::fromWh($value);
    }
}
