<?php

namespace Sundata\Utilities\Time;

use Carbon\CarbonInterface;

class DateSplitter
{
    /**
     * Splits a start-end period in periods. Takes the timezones into account.
     * Don't use for periodType smaller than 'hour'
     *
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @param string $periodType
     * @return Period[]
     */
    public static function split(CarbonInterface $startDate, CarbonInterface $endDate, string $periodType)
    {
        DateSplitter::assertSupportedPeriodType($periodType);
        DateSplitter::assertStartBeforeOrEqualToEnd($startDate, $endDate);
        $next = $startDate->toImmutable();
        $endDate = $endDate->toImmutable();

        if ($startDate->eq($endDate)) {
            return [new Period($startDate->copy(), $endDate)];
        }

        while ($next->isBefore($endDate)) {
            // Carbon->endOf gives the incl boundary, hence use ceiling to obtain excl boundary
            $nextEnd = $next->endOf($periodType)->ceil('minutes')->min($endDate);
            $periods[] = new Period($next, $nextEnd);
            $next = $nextEnd;
        }
        return $periods;
    }

    private static function assertStartBeforeOrEqualToEnd(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        if ($endDate->isBefore($startDate)) {
            throw new \InvalidArgumentException("endDate can't be before startDate.");
        }
    }

    private static function assertSupportedPeriodType(string $periodType)
    {
        if (!in_array($periodType, ['year', 'month', 'week', 'day', 'hour'])) {
            throw new \InvalidArgumentException("Unsupported periodType: " . $periodType);
        }
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return Period[]
     */
    public static function splitInYears(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        return self::split($startDate, $endDate, 'year');
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return Period[]
     */
    public static function splitInMonths(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        return self::split($startDate, $endDate, 'month');
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return Period[]
     */
    public static function splitInWeeks(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        return self::split($startDate, $endDate, 'week');
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return Period[]
     */
    public static function splitInDays(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        return self::split($startDate, $endDate, 'day');
    }

    /**
     * @param CarbonInterface $startDate
     * @param CarbonInterface $endDate
     * @return Period[]
     */
    public static function splitInHours(CarbonInterface $startDate, CarbonInterface $endDate)
    {
        return self::split($startDate, $endDate, 'hour');
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriod(Period $period, string $periodType)
    {
        return self::split($period->startDate, $period->endDate, $periodType);
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriodInYears(Period $period)
    {
        return self::split($period->startDate, $period->endDate, 'year');
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriodInMonths(Period $period)
    {
        return self::split($period->startDate, $period->endDate, 'month');
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriodInWeeks(Period $period)
    {
        return self::split($period->startDate, $period->endDate, 'week');
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriodInDays(Period $period)
    {
        return self::split($period->startDate, $period->endDate, 'day');
    }

    /**
     * @param Period $period
     * @return Period[]
     */
    public static function splitPeriodInHours(Period $period)
    {
        return self::split($period->startDate, $period->endDate, 'hour');
    }
}
