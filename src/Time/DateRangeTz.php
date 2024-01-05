<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonInterface;
use InvalidArgumentException;

class DateRangeTz
{
    private DateTz $from;
    private DateTz $to;

    private function __construct(DateTz $from, DateTz $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public static function of(DateTz $from, DateTz $to): DateRangeTz
    {
        if ($from->timezone() != $to->timezone()) {
            throw new InvalidArgumentException('from and to must have the same timezone');
        }
        if ($to->isBefore($from)) {
            throw new InvalidArgumentException('$to cannot be before $from');
        }
        return new DateRangeTz($from, $to);
    }

    public static function ofStrings(
        string $from,
        string $to,
        string $timezone
    ): DateRangeTz {
        return self::of(
            DateTz::of($from, $timezone),
            DateTz::of($to, $timezone)
        );
    }

    public function from(): DateTz
    {
        return $this->from;
    }

    public function to(): DateTz
    {
        return $this->to;
    }

    public function nrDays(): int
    {
        return $this->from->asCarbonImmutable()
            ->diffInDays($this->to->asCarbonImmutable());
    }

    public function dates(): array
    {
        $timezone = $this->from->timezone();

        if ($this->from->toDateString() === $this->to->toDateString()) {
            return [];
        }

        return array_map(
            fn(Period $day) => DateTz::of($day->getStart()->toDateString(), $timezone),
            DateSplitter::splitInDays($this->from->asCarbonImmutable(), $this->to->asCarbonImmutable())
        );
    }

    public function contains(CarbonInterface $carbon): bool
    {
        $period = new Period($this->from->asCarbonImmutable(), $this->to->asCarbonImmutable());
        return $period->isInPeriod($carbon);
    }

    function toString(): string
    {
        return sprintf("DateRangeTz: %s to %s@%s",
            $this->from->toDateString(),
            $this->to->toDateString(),
            $this->from->timezone()
        );
    }
}
