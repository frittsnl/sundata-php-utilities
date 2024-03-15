<?php

namespace Sundata\Utilities\Measurement;

class Ratio
{
    private float $numerator;
    private float $denominator;

    function __construct(
        int $numerator,
        int $denominator
    ) {
        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    function asDecimalFraction(): float
    {
        return round($this->numerator / $this->denominator, 2);
    }

    function asPercentage(): float
    {
        return round($this->numerator / $this->denominator * 100, 2);
    }
}