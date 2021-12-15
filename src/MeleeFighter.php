<?php

namespace App;

use Error;

class MeleeFighter extends Character
{
    public $range;

    public function __construct()
    {
        parent::__construct();
        $this->range = 2;
    }
}
