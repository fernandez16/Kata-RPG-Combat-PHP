<?php

namespace App;

use Error;

class Character
{
    public $health;
    public $level;
    public $alive;
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

    public function LevelCheck($casterLevel, $targetLevel)
    {
        $levelDifference = $casterLevel - $targetLevel;
        if ($levelDifference >= 5) {
            return 1.5;
        }
        if ($levelDifference <= -5) {
            return 0.5;
        }
        return 1;
    }

    public function RangeCheck($casterRange, $distance)
    {
        return ($casterRange >= $distance);
    }

    public function JoinFaction($faction)
    {
        if ($faction === 1) {
            $this->factions["factionOne"] = 1;
        }
        if ($faction === 2) {
            $this->factions["factionTwo"] = 1;
        }
        if ($faction === 3) {
            $this->factions["factionThree"] = 1;
        }
        if ($faction === 4) {
            $this->factions["factionFour"] = 1;
        }
    }

    public function LeaveFaction($faction)
    {
        if ($faction === 1) {
            $this->factions["factionOne"] = 0;
        }
        if ($faction === 2) {
            $this->factions["factionTwo"] = 0;
        }
        if ($faction === 3) {
            $this->factions["factionThree"] = 0;
        }
        if ($faction === 4) {
            $this->factions["factionFour"] = 0;
        }
    }

    public function SameFactionCheck($casterFactions, $targetFactions)
    {
        foreach ($casterFactions as $faction => $status) {
            if ($status === 0) {
                unset($casterFactions[$faction]);
            }
        }

        foreach ($targetFactions as $faction => $status) {
            if ($status === 0) {
                unset($targetFactions[$faction]);
            }
        }

        if ($casterFactions !== array_diff_key($casterFactions, $targetFactions)) {
            return true;
        }

        return false;
    }

    public function DealDamage($target, $damage, $distance)
    {
        if (
            $this->RangeCheck($this->range, $distance)
            &&
            !$this->SameFactionCheck($this->factions, $target->factions)
            &&
            $this !== $target
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
        if (
            $target->alive === true
            &&
            ($this->SameFactionCheck($this->factions, $target->factions)
                ||
                $this === $target)
        ) {
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
