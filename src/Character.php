<?php

namespace App;

use Error;
use phpDocumentor\Reflection\Types\Intersection;

class Character
{

    private $class;
    private $health;
    private $alive;
    private $level;
    private $range;
    private $strenght;
    private $intelligence;
    private $position;
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
        $this->alive = true;
        $this->level = 1;
        $this->strenght = 3;
        $this->intelligence = 3;
        $this->position = array(
            "x" => 0,
            "y" => 0,
        );
        $this->factions = array();
    }

    public function moveCharacter($movement)
    {
        $finalPosition = $this->position;
        array_walk(
            $finalPosition,
            function (&$val, $coordinate, $movementWalk) {
                $val += $movementWalk[$coordinate];
            },
            $movement
        );
        $this->position = $finalPosition;
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

    public function LevelCheck($caster, $target)
    {
        if (get_class($target) !== "App\Character") {
            return 1;
        }
        $levelDifference = $caster->getLevel() - $target->getLevel();
        if ($levelDifference >= 5) {
            return 1.5;
        }
        if ($levelDifference <= -5) {
            return 0.5;
        }
        return 1;
    }

    public function CalculateDistance($targetPosition)
    {
        $distanceDifference = $this->position;
        array_walk(
            $distanceDifference,
            function (&$val, $coordinate, $movementWalk) {
                $val -= $movementWalk[$coordinate];
            },
            $targetPosition
        );
        $distance = 0;
        foreach ($distanceDifference as $value) {
            $distance += abs($value);
        };
        return $distance;
    }

    public function targeteabilityCheck($target)
    {
        if (get_class($target) === "App\Character") {
            if ($target->getHealth() > 0 && $target->getAlive() === true) {
                return true;
            }
        }

        if (get_class($target) === "App\Prop") {
            if ($target->getHealth() > 0) {
                return true;
            }
        }

        return false;
    }

    public function RangeCheck($casterRange, $targetPosition)
    {
        $distance = $this->CalculateDistance($targetPosition);
        return ($casterRange >= $distance);
    }

    public function JoinFaction($faction)
    {
        array_push($this->factions, $faction);
    }

    public function LeaveFaction($faction)
    {
        $this->factions = array_diff($this->factions, array($faction));
    }

    public function SameFactionCheck($caster, $target)
    {
        if (get_class($target) !== "App\Character") {
            return false;
        }
        if (array_intersect($caster->getFactions(), $target->getFactions())) {
            return true;
        }
        return false;
    }

    public function DealDamage($target)
    {
        if (
            $this->targeteabilityCheck($target)
            &&
            $this->RangeCheck($this->range, $target->getPosition())
            &&
            !$this->SameFactionCheck($this, $target)
            &&
            $this !== $target
        ) {
            $damage = $this->CalculateDamage();
            $damageMultiplier = $this->LevelCheck($this, $target);
            $target->setHealth($target->getHealth() - $damage * $damageMultiplier);
            if ($target->getHealth() <= 0) {
                if (get_class($target) !== "App\Character") {
                    unset($target);
                    return;
                }
                $target->setHealth(0);
                $target->setAlive(false);
            }
        }
    }

    public function HealDamage($target)
    {
        if (
            $this->targeteabilityCheck($target)
            &&
            ($this->SameFactionCheck($this, $target)
                ||
                $this === $target)
        ) {
            $target->setHealth($target->getHealth() + $this->CalculateHealing());
            if ($target->health >= 1000) {
                $target->setHealth(1000);
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

    public function setHealth($health)
    {
        $this->health = $health;

        return $this;
    }

    public function getAlive()
    {
        return $this->alive;
    }

    public function setAlive($alive)
    {
        $this->alive = $alive;

        return $this;
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

    public function getPosition()
    {
        return $this->position;
    }

    public function getFactions()
    {
        return $this->factions;
    }
}
