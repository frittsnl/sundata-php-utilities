<?php

namespace Sundata\Utilities\String;

use InvalidArgumentException;

class StringUtil
{
    /**
     * Throws InvalidArgumentException if $ranges is not like 1,3-7,10 etc.
     *
     * @param string $ranges
     * @return int[]
     */
    public static function explodeRangesToArrayOfIntegers(string $ranges): array
    {
        self::assertValidInput($ranges);

        return array_reduce(
            $commaExploded = explode(',', $ranges),
            function ($carry, $item) {
                $subItems = explode('-', $item);
                return array_merge($carry,
                    2 === count($subItems)
                        ? range($subItems[0], $subItems[1])
                        : [intval($item)]
                );
            },
            $startingCarry = []
        );
    }

    private static function assertValidInput(string $ranges): void
    {
        $spacelessRanges = str_replace(' ', '', $ranges);
        $intOrRangePattern = '\d+(-\d+)?';
        $pattern = "/^$intOrRangePattern(,$intOrRangePattern)*$/";
        $matches = [];

        if (!preg_match($pattern, $spacelessRanges, $matches)) {
            throw new InvalidArgumentException("Invalid ranges given: $ranges");
        }
    }
}