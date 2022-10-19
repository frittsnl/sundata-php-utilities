<?php

namespace Sundata\Utilities\Measurement;

class FormattedMeasurement
{
    public $value;
    public $unit;

    public function __construct(
        float $value,
        string $unit
    ) {
        $this->value = $value;
        $this->unit = $unit;
    }

    public function __toString(): string
    {
        return $this->value . ' ' . $this->unit;
    }

}
