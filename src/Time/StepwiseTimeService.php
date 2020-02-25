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
     * @param CarbonInterface $now
     */
    public function __construct(CarbonInterface $now)
    {
        $this->now = $now->toImmutable();
    }

    function now(): CarbonImmutable
    {
        return $this->now;
    }

    function forward(DateInterval $dateInterval): CarbonImmutable
    {
        return $this->now = $this->now->add($dateInterval);
    }

    function setNow(CarbonInterface $newNow)
    {
        $this->now = $newNow->toImmutable();
    }
}