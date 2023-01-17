<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonInterface;

class Period
{
    public $startDate;
    public $endDate;

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     */
    public function __construct(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function getStart(): CarbonInterface
    {
        return $this->startDate;
    }

    public function getEnd(): CarbonInterface
    {
        return $this->endDate;
    }

    public function inSeconds(): int
    {
        return $this->startDate->diffInSeconds($this->endDate);
    }

    public function inMinutes(): float
    {
        return $this->inSeconds() / 60;
    }

    public function inHours(): float
    {
        return $this->inSeconds() / 60 / 60;
    }

    public function inDays(): float
    {
        return $this->inSeconds() / 60 / 60 / 24;
    }

    public function inWeeks(): float
    {
        return $this->inSeconds() / 60 / 60 / 24 / 7;
    }

    /** Tells if given date is within period, end is exclusive boundary */
    public function isInPeriod(CarbonInterface $date): bool
    {
        return $this->startDate <= $date && $date < $this->endDate;
    }

    public function toString(): string
    {
        return $this->__toString();
    }

    function __toString()
    {
        return "Period[{$this->getStart()->toRfc3339String()};{$this->getEnd()->toRfc3339String()}]";
    }

    function splitOnDstTransitions(): array
    {
        $events = [$this->getStart()];

        for ($y = $this->getStart()->year; $y <= $this->getEnd()->year; ++$y) {
            $dstStart = DstTransitions::getDstStart($y);
            if ($this->isInPeriod($dstStart)) {
                $events[] = $dstStart;
            }
            $dstEnd = DstTransitions::getDstEnd($y);
            if ($this->isInPeriod($dstEnd)) {
                $events[] = $dstEnd;
            }
        }

        $events[] = $this->getEnd();

        $result = [];
        for ($i = 0; $i + 1 < count($events); ++$i) {
            $result[] = new Period($events[$i], $events[$i + 1]);
        }
        return $result;
    }

    public function getOverlap(Period $periodB): ?Period
    {
        $min = $this->getStart()->max($periodB->getStart());
        $max = $this->getEnd()->min($periodB->getEnd());
        return $min->isBefore($max) ? new Period($min, $max) : null;
    }

    public function hasOverlap(Period $periodB): bool
    {
        return (bool)$this->getOverlap($periodB);
    }
}
