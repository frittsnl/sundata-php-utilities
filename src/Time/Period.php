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
