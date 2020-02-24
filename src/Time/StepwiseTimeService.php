<?php


namespace Sundata\Utilities\Time;


use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use DateInterval;

class StepwiseTimeService implements TimeService
{
    /** @var CarbonImmutable */
    private $now;

    /**
     * StepwiseTimeService constructor.
     * @param $now
     */
    public function __construct($now)
    {
        $this->now = $now;
    }

    function now(): CarbonImmutable
    {
        return $this->now;
    }

    function forward(DateInterval $dateInterval): CarbonImmutable
    {
        return $this->now->add($dateInterval);
    }

    function setNow(CarbonInterface $newNow)
    {
        $this->now = $newNow->toImmutable();
    }
}