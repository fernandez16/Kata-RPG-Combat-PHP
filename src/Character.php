<?php

namespace App;

use Error;

class Character
{
    public $health;
    public $level;
    public $alive;
    public $class;
    public $factions;

    public function __construct()
    {
        $this->health = 1000;
        $this->level = 1;
        $this->alive = true;
        $this->factions = array(
            "factionOne" => 0,
            "factionTwo" => 0,
            "factionThree" => 0,
            "factionFour" => 0,
        );
    }

    public function JoinFaction($faction)
    {
        if ($faction === 1) {
            $this->faction["factionOne"] = 1;
        }
        if ($faction === 2) {
            $this->faction["factionTwo"] = 1;
        }
        if ($faction === 3) {
            $this->faction["factionThree"] = 1;
        }
        if ($faction === 4) {
            $this->faction["factionFour"] = 1;
        }
    }

    public function LeaveFaction($faction)
    {
        if ($faction === 1) {
            $this->faction["factionOne"] = 0;
        }
        if ($faction === 2) {
            $this->faction["factionTwo"] = 0;
        }
        if ($faction === 3) {
            $this->faction["factionThree"] = 0;
        }
        if ($faction === 4) {
            $this->faction["factionFour"] = 0;
        }
    }

    public function LevelCheck($casterLevel, $targetLevel)
    {
        $levelDifference = $casterLevel - $targetLevel;
        if ($levelDifference >= 5) {
            return 1.5;
        }
        if ($levelDifference <= -5) {
            return 0.75;
        }
        return 1;
    }

    public function RangeCheck($casterRange, $distance)
    {
        return ($casterRange >= $distance);
    }

    public function SameFactionCheck($casterFaction, $targetFaction)
    {
        foreach ($casterFaction as $faction => $status) {
            if ($status === 0) {
                unset($casterFaction[$faction]);
            }
        }
        foreach ($targetFaction as $faction => $status) {
            if ($status === 0) {
                unset($targetFaction[$faction]);
            }
        }

        if ($casterFaction !== array_diff_key($casterFaction, $targetFaction)) {
            return true;
        }

        return false;
    }

    public function DealDamage($target, $damage, $distance)
    {
        if ($this === $target) {
            return;
        }
        if (
            $this->RangeCheck($this->range, $distance)
            &&
            !$this->SameFactionCheck($this->faction, $target->faction)
        ) {
            $damageMultiplier = $this->LevelCheck($this->level, $target->level);
            $target->health = $target->health - $damage * $damageMultiplier;
            if ($target->health <= 0) {
                $target->health = 0;
                $target->alive = false;
            }
        }
    }

    public function HealDamage($target, $heal)
    {
        if ($target->alive === true && $this->SameFactionCheck($this->faction, $target->faction)) {
            $target->health = $target->health + $heal;
            if ($target->health >= 1000) {
                $target->health = 1000;
                return;
            }
            return;
        };
        return;
    }
}