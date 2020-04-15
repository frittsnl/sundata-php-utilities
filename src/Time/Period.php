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

  public function getStart()
  {
    return $this->startDate;
  }

  public function getEnd()
  {
    return $this->endDate;
  }

  public function inSeconds(): int
  {
    return $this->startDate->diffInSeconds($this->endDate);
  }

  public function inMinutes(): float
  {
    return round($this->inSeconds() / 60, 2);
  }

  public function inHours(): float
  {
    return round($this->inSeconds() / 60 / 60, 2);
  }

  public function inDays(): float
  {
    return round($this->inSeconds() / 60 / 60 / 24, 2);
  }

  public function inWeeks(): float
  {
    return round($this->inSeconds() / 60 / 60 / 24 / 7, 2);
  }

  /**
   * @return string
   * @deprecated
   */
  public function toString()
  {
    return "Period[{$this->getStart()->toRfc3339String()};{$this->getEnd()->toRfc3339String()}]";
  }

  function __toString()
  {
    return "Period[{$this->getStart()->toRfc3339String()};{$this->getEnd()->toRfc3339String()}]";
  }
}
