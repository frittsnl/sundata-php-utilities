<?php

namespace Sundata\Utilities\Measurement;

use RuntimeException;

class Ratio
{
    private int $numerator;
    private int $denominator;

    function __construct(
        int $numerator,
        int $denominator
    ) {
        if ($denominator === 0) {
            throw new RuntimeException('Denominator cannot be zero');
        }

        $this->numerator = $numerator;
        $this->denominator = $denominator;
    }

    function asDecimalFraction(
        int $precision = 2
    ): float {
        return round($this->numerator / $this->denominator, $precision);
    }

    function asPercentage(
        int $precision = 2
    ): float {
        return round($this->numerator / $this->denominator * 100, $precision);
    }
}