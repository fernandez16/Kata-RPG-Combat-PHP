<?php

namespace App;

use Error;

class RangedFighter extends Character
{
    public $range;

    public function __construct()
    {
        parent::__construct();
        $this->range = 20;
    }
}
