<?php

namespace Sundata\Utilities\Measurement;

use InvalidArgumentException;

abstract class Measurement
{
    abstract public function __toString(): string;

    abstract protected function getValue();

    abstract static protected function fromValue($value): self;

    function multiplyBy(Ratio $ratio): self
    {
        $newValue = $this->getValue() * $ratio->asDecimalFraction(6);
        return $this->fromValue($newValue);
    }

    function multiplyByFloat(float $float): self
    {
        return $this->fromValue($this->getValue() * $float);
    }

    function divideBy(self $other): Ratio
    {
        Measurement::assertSameUnits($this, $other);
        $bigFactor = 1E6;
        return new Ratio(
            $bigFactor * $this->getValue(),
            $bigFactor * $other->getValue()
        );
    }

    function subtract(self $other): self
    {
        Measurement::assertSameUnits($this, $other);
        return $this->fromValue($this->getValue() - $other->getValue());
    }

    function add(self $other): self
    {
        Measurement::assertSameUnits($this, $other);
        return $this->fromValue($this->getValue() + $other->getValue());
    }

    private static function assertSameUnits(Measurement $param, Measurement $other)
    {
        if (get_class($param) !== get_class($other)) {
            throw new InvalidArgumentException("Can't mix units for operation");
        }
    }
}
