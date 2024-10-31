<?php

namespace Sundata\Utilities\Test\Measurement;

use InvalidArgumentException;
use PHPUnit\Framework\Assert;
use PHPUnit\Framework\TestCase;
use Sundata\Utilities\Measurement\Irradiance;
use Sundata\Utilities\Measurement\Mass;
use Sundata\Utilities\Measurement\Ratio;

class IrradianceTest extends TestCase
{
    function testMultiplication()
    {
        Assert::assertEquals(
            Irradiance::fromJcm2(50),
            Irradiance::fromJcm2(100)
                ->multiplyBy(new Ratio(1, 2))
        );
    }

    function testMultiplicationReturnType()
    {
        Assert::assertTrue(
            Irradiance::fromJcm2(100)
                ->multiplyBy(new Ratio(1, 2))
            instanceof
            Irradiance
        );
    }

    function testAddition()
    {
        Assert::assertEquals(
            Irradiance::fromJcm2(13),
            Irradiance::fromJcm2(5)
                ->add(Irradiance::fromJcm2(8))
        );
    }

    function testSubtraction()
    {
        Assert::assertEquals(
            Irradiance::fromJcm2(3),
            Irradiance::fromJcm2(5)
                ->subtract(Irradiance::fromJcm2(2))
        );
    }

    function testCannotDivideByOtherUnits()
    {
        $this->expectException(InvalidArgumentException::class);
        Irradiance::fromJcm2(1)
            ->divideBy(Mass::fromKg(2));
    }

    function testCannotAddDifferentUnits()
    {
        $this->expectException(InvalidArgumentException::class);
        Irradiance::fromJcm2(1)
            ->add(Mass::fromKg(2));
    }

    function testMultiplyByFloat()
    {
        self::assertEquals(
            Irradiance::fromJcm2(8),
            Irradiance::fromJcm2(4)->multiplyByFloat(2.1)
        );
    }
}

