<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonImmutable;
use DateTimeZone;
use InvalidArgumentException;

class DateTz
{
    /** @var Date */
    private $date;
    /** @var string */
    private $timezone;

    /** @var CarbonImmutable|null */
    private $carbon = null;

    private function __construct(Date $date, string $timezone)
    {
        $this->date = $date;
        $this->timezone = $timezone;
    }

    public static function of(string $dateString, string $timezone): DateTz
    {
        if ($timezone && !in_array($timezone, DateTimeZone::listIdentifiers())) {
            throw new InvalidArgumentException('Unknown timezone identifier');
        }

        return new DateTz(
            Date::of($dateString),
            $timezone
        );
    }

    public function toDate(): Date
    {
        return $this->date;
    }

    function asCarbonImmutable(): CarbonImmutable
    {
        if (is_null($this->carbon)) {
            $this->carbon = CarbonImmutable::parse(
                $this->toDateString(),
                $this->timezone
            );
        }
        return $this->carbon;
    }

    function toDateString(): string
    {
        // for convenience
        return $this->date->toDateString();
    }

    function toString(): string
    {
        return sprintf("DateTz: %s@%s",
            $this->toDateString(),
            $this->timezone
        );
    }

    function addDays(int $days): DateTz
    {
        return new DateTz(
            $this->date->addDays($days),
            $this->timezone
        );
    }

    public function timezone(): string
    {
        return $this->timezone;
    }

    function setTimezone(string $timezone): DateTz
    {
        return new DateTz($this->date, $timezone);
    }

    private function assertSameTimezone(DateTz $dateTz)
    {
        if ($this->timezone !== $dateTz->timezone) {
            throw new InvalidArgumentException("Using different timezone is not supported");
        }
    }

    public function isBefore(DateTz $dateTz): bool
    {
        $this->assertSameTimezone($dateTz);
        return $this->date->isBefore($dateTz->date);
    }

    public function isAfter(DateTz $dateTz): bool
    {
        $this->assertSameTimezone($dateTz);
        return $this->date->isAfter($dateTz->date);
    }

    public function min(DateTz $dateTz): DateTz
    {
        $this->assertSameTimezone($dateTz);
        return $this->isBefore($dateTz) ? $this : $dateTz;
    }

    public function max(DateTz $dateTz): DateTz
    {
        $this->assertSameTimezone($dateTz);
        return $this->isAfter($dateTz) ? $this : $dateTz;
    }
}
