<?php

namespace App;

use Error;

class Character
{

    private $class;
    private $health;
    private $level;
    private $strenght;
    private $intelligence;
    private $range;
    private $alive;
    private $factions;

    public function __construct($choosenClass)
    {
        if ($choosenClass === "Melee Fighter") {
            $this->class = "Melee Fighter";
            $this->range = 2;
        } elseif ($choosenClass === "Ranged Fighter") {
            $this->class = "Ranged Fighter";
            $this->range = 20;
        }
        $this->health = 1000;
        $this->level = 1;
        $this->strenght = 3;
        $this->intelligence = 3;
        $this->alive = true;
        $this->factions = array(
            "factionOne" => 0,
            "factionTwo" => 0,
            "factionThree" => 0,
            "factionFour" => 0,
        );
    }

    public function CalculateDamage()
    {
        $damage = $this->strenght * 40;
        return $damage;
    }

    public function CalculateHealing()
    {
        $heal = $this->strenght * 20;
        return $heal;
    }

    public function LevelUp()
    {
        $this->level++;
        if ($this->level % 2 === 0) {
            $this->strenght++;
            $this->intelligence++;
        }
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

    public function DealDamage($target, $distance)
    {
        if (
            $this->RangeCheck($this->range, $distance)
            &&
            !$this->SameFactionCheck($this->factions, $target->factions)
            &&
            $this !== $target
        ) {
            $damage = $this->CalculateDamage();
            $damageMultiplier = $this->LevelCheck($this->level, $target->level);
            $target->health = $target->health - $damage * $damageMultiplier;
            if ($target->health <= 0) {
                $target->health = 0;
                $target->alive = false;
            }
        }
    }

    public function HealDamage($target)
    {
        if (
            $target->alive === true
            &&
            ($this->SameFactionCheck($this->factions, $target->factions)
                ||
                $this === $target)
        ) {
            $target->health = $target->health + $this->CalculateHealing();
            if ($target->health >= 1000) {
                $target->health = 1000;
            }
        };
    }

    public function getClass()
    {
        return $this->class;
    }

    public function getHealth()
    {
        return $this->health;
    }

    public function getLevel()
    {
        return $this->level;
    }

    public function getRange()
    {
        return $this->range;
    }

    public function getStrenght()
    {
        return $this->strenght;
    }

    public function getIntelligence()
    {
        return $this->intelligence;
    }

    public function getAlive()
    {
        return $this->alive;
    }

    public function getFactions()
    {
        return $this->factions;
    }
}
