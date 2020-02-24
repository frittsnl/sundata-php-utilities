<?php


namespace Sundata\Utilities\Time;


use Carbon\CarbonImmutable;

interface TimeService
{
    function now(): CarbonImmutable;
}