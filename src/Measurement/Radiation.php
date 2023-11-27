<?php

namespace Sundata\Utilities\Measurement;

class Radiation implements Measurement
{
    private function __construct(
        private int $jcm2
    ) { }

    static function fromJcm2(int $jcm2): Radiation
    {
        return new Radiation($jcm2);
    }

    static function fromkJm2(int $kJm2): Radiation
    {
        return new Radiation($kJm2 / 10);
    }

    function asJcm2(): int
    {
        return $this->jcm2;
    }

    function asKJm2(): int
    {
        return $this->jcm2 * 10;
    }

    function asMJm2(): int
    {
        return $this->jcm2 / 100;
    }

    /** @noinspection PhpPureAttributeCanBeAddedInspection */
    function format(): FormattedMeasurement
    {
        return new FormattedMeasurement(
            $this->asJcm2(),
            'J/cm2'
        );
    }

    function __toString(): string
    {
        return $this->format()->__toString();
    }
}