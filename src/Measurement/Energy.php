<?php

namespace Sundata\Utilities\Measurement;

class Energy implements Measurement
{
    // Immutable
    private $wattHour;

    private function __construct(
        float $wattHour
    ) {
        $this->wattHour = $wattHour;
    }

    // factory-methods
    public static function fromKwh(float $kwh): Energy
    {
        return new Energy($kwh * 1000);
    }

    // out
    public function asKwh(): float
    {
        return $this->wattHour / 1E3;
    }

    public function asMwh(): float
    {
        return $this->wattHour / 1E6;
    }

    public function format()
    {
        /*
         * $energy = Energy::fromKwh( $actual_yield_in_kwh);
         * ...
         * <b>$energy->format()->value</b>
         * $energy->format()->unit
         */

        $unit = ...;
        $factor = ...;
        return [
            $this->wattHour * $factor,
            $unit
        ];

    }

    public function __toString($precision = 3): string
    {
        if ($this->wattHour < 1000) {

        } elseif (true) {

        };
        //logic
    }

    public function asFloat(): float
    {
        return $this->wattHour;
    }
}
