<?php

namespace App;

use Error;

class Prop
{
    private $health;
    private $position;

    public function __construct($health, $position)
    {
        $this->health = $health;
        $this->position = $position;
    }

    public function __destruct()
    {
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    public function getPosition()
    {
        return $this->position;
    }
}
