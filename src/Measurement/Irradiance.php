<?php

namespace Sundata\Utilities\Measurement;

class Irradiance extends Measurement
{
    private int $jcm2;

    private function __construct(int $jcm2)
    {
        $this->jcm2 = $jcm2;
    }

    static function fromJcm2(int $jcm2): Irradiance
    {
        return new Irradiance($jcm2);
    }

    static function fromkJm2(int $kJm2): Irradiance
    {
        return new Irradiance($kJm2 / 10);
    }

    static function fromWhm2(int $whm2): Irradiance
    {
        return new Irradiance($whm2 * 0.36);
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

    protected function getValue()
    {
        return $this->jcm2;
    }

    protected static function fromValue($value): self
    {
        return Irradiance::fromJcm2((int)$value);
    }
}
