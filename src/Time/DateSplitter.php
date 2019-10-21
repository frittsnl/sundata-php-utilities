<?php

namespace Sundata\Utilities\Time;

use Carbon\Carbon;

/**
 * Class DataArraySerializer
 *
 * This class is a subclass of ArraySerializer which removes the 'data'
 * resource key from the json array.
 *
 * @package App\Infrastructure\Support
 */
class DateSplitter
{
  /**
   * Get the collection array without the prefixed resource key 'data'.
   *
   * @param Carbon $startDate
   * @param Carbon $endDate
   * @param string $periodType
   * @return array
   */
  public function split($startDate, $endDate, $periodType)
  {
    switch ($periodType) {
      case 'year':
        return $this->splitInYears($startDate, $endDate);
      case 'month':
        return $this->splitInMonths($startDate, $endDate);
      case 'week':
        return $this->splitInWeeks($startDate, $endDate);
      case 'day':
        return $this->splitInDays($startDate, $endDate);
      case 'hour':
      default:
        return $this->splitInHours($startDate, $endDate);
    }
  }

  public function splitInYears($startDate, $endDate)
  {
    $nextStart = $startDate;

    while ($nextStart <= $endDate) {

      $endInPeriod = $nextStart->copy()->endOfYear();

      if ($endDate < $endInPeriod) {
        $endInPeriod = $endDate;
      }

      $newPeriod = new Period($nextStart, $endInPeriod);

      $periods[] = $newPeriod;

      $nextStart = $nextStart->copy()->endOfYear()->addDay()->startOfDay();
    }

    return $periods;
  }

  public function splitInMonths($startDate, $endDate)
  {
    $nextStart = $startDate;

    while ($nextStart <= $endDate) {

      $endInPeriod = $nextStart->copy()->endOfMonth();

      if ($endDate < $endInPeriod) {
        $endInPeriod = $endDate;
      }

      $newPeriod = new Period($nextStart, $endInPeriod);

      $periods[] = $newPeriod;

      $nextStart = $nextStart->copy()->endOfMonth()->addDay()->startOfDay();
    }

    return $periods;
  }

  public function splitInWeeks($startDate, $endDate)
  {
    $nextStart = $startDate;

    while ($nextStart <= $endDate) {

      $endInPeriod = $nextStart->copy()->endOfWeek();

      if ($endDate < $endInPeriod) {
        $endInPeriod = $endDate;
      }

      $newPeriod = new Period($nextStart, $endInPeriod);

      $periods[] = $newPeriod;

      $nextStart = $nextStart->copy()->endOfWeek()->addDay()->startOfDay();
    }

    return $periods;
  }

  public function splitInDays($startDate, $endDate)
  {
    $nextStart = $startDate;

    while ($nextStart <= $endDate) {

      $endInPeriod = $nextStart->copy()->endOfDay();

      if ($endDate < $endInPeriod) {
        $endInPeriod = $endDate;
      }

      $newPeriod = new Period($nextStart, $endInPeriod);

      $periods[] = $newPeriod;

      $nextStart = $nextStart->copy()->endOfDay()->addDay()->startOfDay();
    }

    return $periods;
  }

  public function splitInHours($startDate, $endDate)
  {

    $nextStart = $startDate;

    while ($nextStart < $endDate) {
      $endInPeriod = $nextStart->copy()->endOfHour();

      // If the generated end time is larger then the actual end date, use the original one.
      if ($endInPeriod > $endDate) {
        $endInPeriod = $endDate;
      }

      $newPeriod = new Period($nextStart, $endInPeriod);

      $periods[] = $newPeriod;

      $nextStart = $nextStart->copy()->addHour()->startOfHour();
    }

    return $periods;
  }
}
