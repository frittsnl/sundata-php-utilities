<?php

namespace Sundata\Utilities\Measurement;

class Weight implements Measurement
{
    private float $gram;

    private function __construct(
        $gram
    ) {
        $this->gram = $gram;
    }

    public static function fromKg(float $kg): Weight
    {
        return new Weight($kg * 1000);
    }

    public function asGr(): float
    {
        return $this->gram;
    }

    public function asKg(): float
    {
        return $this->gram / 1E3;
    }

    public function asT(): float
    {
        return $this->gram / 1E6;
    }

    public function asMt(): float
    {
        return $this->gram / 1E12;
    }

    public function asGt(): float
    {
        return $this->gram / 1E15;
    }

    public function format(int $precision = 2): FormattedMeasurement
    {
        if ($this->gram >= 1E14) {
            return new FormattedMeasurement(
                round($this->asGt(), $precision),
                'Gt'
            );
        }
        if ($this->gram >= 1E11) {
            return new FormattedMeasurement(
                round($this->asMt(), $precision),
                'Mt'
            );
        }
        if ($this->gram >= 1E7) {
            return new FormattedMeasurement(
                round($this->asT(), $precision),
                't'
            );
        }
        if ($this->gram >= 1E4) {
            return new FormattedMeasurement(
                round($this->asKg(), $precision),
                'kg'
            );
        }
        return new FormattedMeasurement(
            round($this->asGr(), $precision),
            'g'
        );
    }

    public function __toString(): string
    {
        return $this->format()->__toString();
    }

}
