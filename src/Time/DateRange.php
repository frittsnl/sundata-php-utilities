<?php

namespace Sundata\Utilities\Time;

use Carbon\Carbon;
use InvalidArgumentException;

class DateRange
{
    private Date $from;
    private Date $to;

    private function __construct(Date $from, Date $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public static function of(Date $from, Date $to): DateRange
    {
        $dateRange = new DateRange($from, $to);

        list($carbonFrom, $carbonTo) = $dateRange->fromToAsCarbon();
        if ($carbonTo->isBefore($carbonFrom)) {
            throw new InvalidArgumentException('$to cannot be before $from');
        }
        return $dateRange;
    }

    public static function ofStrings(string $from, string $to): DateRange
    {
        return self::of(
            Date::of($from),
            Date::of($to)
        );
    }

    public function from(): Date
    {
        return $this->from;
    }

    public function to(): Date
    {
        return $this->to;
    }

    private function fromToAsCarbon(): array
    {
        return [
            Carbon::parse($this->from->toDateString()),
            Carbon::parse($this->to->toDateString())
        ];
    }

    public function nrDays(): int
    {
        list($fromCarbon, $toCarbon) = $this->fromToAsCarbon();
        return $fromCarbon->diffInDays($toCarbon);
    }

    public function dates(): array
    {
        if ($this->from->toDateString() === $this->to->toDateString()) {
            return [];
        }

        return array_map(
            fn(Period $day) => Date::of($day->getStart()->toDateString()),
            DateSplitter::splitInDays(...$this->fromToAsCarbon())
        );
    }

    function toString(): string
    {
        return sprintf("DateRange: %s to %s",
            $this->from->toDateString(),
            $this->to->toDateString(),
        );
    }
}
