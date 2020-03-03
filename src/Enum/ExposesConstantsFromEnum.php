<?php

namespace Sundata\Utilities\Enum;

use ReflectionClass;

trait ExposesConstantsFromEnum
{
    public static function getConstants(string $prefix): array
    {
        /** @noinspection PhpUnhandledExceptionInspection accepted */
        $reflectionClass = new ReflectionClass(get_called_class());
        $result = [];
        foreach ($reflectionClass->getConstants() as $key => $value) {
            if (substr($key, 0, strlen($prefix)) === $prefix) {
                $result[$key] = $value;
            }
        }
        return $result;
    }
}
