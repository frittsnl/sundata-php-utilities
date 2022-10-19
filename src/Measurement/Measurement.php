<?php

namespace Sundata\Utilities\Measurement;

interface Measurement
{
    public function asFloat(): float;

    public function __toString(): string;
}
