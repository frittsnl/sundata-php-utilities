<?php


namespace Sundata\Utilities\Test\Enum;


use Sundata\Utilities\Enum\ExposesConstantsFromEnum;
use PHPUnit\Framework\TestCase;

class EnumClassForTesting
{
    use ExposesConstantsFromEnum;

    const key_A = "value_A";
    const key_B = "value_B";
    const key_C = "value_C";
    const key_D = "value_D";

    const other_A = "foo_A";
    const ARRAY_KEY = [1, 2, 3];
}

class ExposesConstantsFromEnumTest extends TestCase
{
    /** @test */
    function testNrReturned()
    {
        $constantsWithKeyPrefix = EnumClassForTesting::getConstants('key_');
        $this->assertEquals(4, count($constantsWithKeyPrefix));
    }

    /** @test */
    function testValue()
    {
        $constantKeyA = EnumClassForTesting::getConstants('key_A');
        $this->assertEquals('value_A', $constantKeyA['key_A']);
    }

    /** @test */
    function testArray()
    {
        $arrayConstName = 'ARRAY_KEY';
        $constant = EnumClassForTesting::getConstants($arrayConstName);
        $this->assertEquals([1, 2, 3], $constant[$arrayConstName]);
    }
}