<?php

namespace Sundata\Utilities\Sun;

class DecRa
{
    public $dec;
    public $ra;

    function __construct($d, $r)
    {
        $this->dec = $d;
        $this->ra = $r;
    }
}