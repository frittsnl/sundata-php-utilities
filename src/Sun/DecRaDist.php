<?php

namespace Sundata\Utilities\Sun;

class DecRaDist extends DecRa
{
    public $dist;

    function __construct($d, $r, $dist)
    {
        parent::__construct($d, $r);
        $this->dist = $dist;
    }
}