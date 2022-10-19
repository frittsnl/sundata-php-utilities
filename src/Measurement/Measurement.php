<?php

namespace Sundata\Utilities\Measurement;

interface Measurement
{
    public function setPrecision(int $precision): void;
    public function getPrecision(): int;

    public function asFloat(): float;

    public function __toString(): string;
}
