<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonImmutable;
use InvalidArgumentException;

/** Represents a date WITHOUT time */
class Date
{
    /** @var string */
    private $dateString;

    private function __construct(string $dateString)
    {
        $this->dateString = $dateString;
    }

    static function of(string $dateString): Date
    {
        if (!preg_match('/^(19|20)\d{2}-[01]\d-[0123]\d$/', $dateString)) {
            throw new InvalidArgumentException('Invalid date format. Use 20YY-MM-DD');
        }
        return new Date($dateString);
    }

    function toDateString(): string
    {
        return $this->dateString;
    }

    function toDateTz(string $timezone): DateTz
    {
        return DateTz::of($this->dateString, $timezone);
    }

    function toString(): string
    {
        return sprintf("Date: %s", $this->dateString);
    }

    function addDays(int $days): Date
    {
        return new Date(
            CarbonImmutable::parse($this->dateString)
                ->addDays($days)
                ->toDateString()
        );
    }

    public function isBefore(Date $date): bool
    {
        return $this->toDateString() < $date->toDateString();
    }

    public function isAfter(Date $date): bool
    {
        return $this->toDateString() > $date->toDateString();
    }

    public function max(Date $date): Date
    {
        return $this->isAfter($date) ? $this : $date;
    }

    public function min(Date $date): Date
    {
        return $this->isBefore($date) ? $this : $date;
    }
}
