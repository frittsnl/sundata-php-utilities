<?php

namespace Sundata\Utilities\Sun;

class AzAltDist extends AzAlt
{
    public $dist;

    function __construct($az, $alt, $dist)
    {
        parent::__construct($az, $alt);
        $this->dist = $dist;
    }
}