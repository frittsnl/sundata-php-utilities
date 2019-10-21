<?php

namespace Sundata\Utilities\Time;

class Period
{
    public $startDate;
    public $endDate;

    /**
     * @var Carbon $startDate
     * @var Carbon $endDate
     */
    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

}
