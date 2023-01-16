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
        if ($from->timezone() != $to->timezone()) {
            throw new InvalidArgumentException('from and to must have the same timezone');
        }

        $dateRange = new DateRange($from, $to);

        list($carbonFrom, $carbonTo) = $dateRange->fromToAsCarbon();
        if ($carbonTo->isBefore($carbonFrom)) {
            throw new InvalidArgumentException('$to cannot be before $from');
        }

        return $dateRange;
    }

    public static function ofStrings(string $from, string $to, ?string $timezone = null): DateRange
    {
        return self::of(
            Date::of($from, $timezone),
            Date::of($to, $timezone)
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
            $this->from->hasTimezone() ? $this->from->asCarbonImmutable() : Carbon::parse($this->from->toDateString()),
            $this->to->hasTimezone() ? $this->to->asCarbonImmutable() : Carbon::parse($this->to->toDateString())
        ];
    }

    public function nrDays(): int
    {
        list($fromCarbon, $toCarbon) = $this->fromToAsCarbon();
        return $fromCarbon->diffInDays($toCarbon);
    }

    public function dates(): array
    {
        $timezone = $this->from->timezone();

        if ($this->from->toDateString() === $this->to->toDateString()) {
            return [];
        }

        return array_map(
            fn(Period $day) => Date::of($day->getStart()->toDateString(), $timezone),
            DateSplitter::splitInDays(...$this->fromToAsCarbon())
        );
    }

    function toString(): string
    {
        return sprintf("DateRange: %s to %s@%s",
            $this->from->toDateString(),
            $this->to->toDateString(),
            $this->from()->hasTimezone() ? $this->from()->timezone() : '<none>'
        );
    }
}
