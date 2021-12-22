<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\Prop;

class CharacterTest extends TestCase
{

	public function test_meleeFighter_correctly_created()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$classResult = $character->getClass();
		$healthResult = $character->getHealth();
		$levelResult = $character->getLevel($character);
		$rangeResult = $character->getRange();
		$aliveResult = $character->getAlive();
		$factionResult = $character->getFactions();
		// Then
		$this->assertEquals("Melee Fighter", $classResult);
		$this->assertEquals(1000, $healthResult);
		$this->assertEquals(1, $levelResult);
		$this->assertEquals(true, $aliveResult);
		$this->assertEquals(2, $rangeResult);
		$this->assertEquals(array(), $factionResult);
	}

	public function test_rangedFighter_correctly_created()
	{
		// Given
		$character = new Character("Ranged Fighter");
		// When 
		$classResult = $character->getClass();
		$healthResult = $character->getHealth();
		$levelResult = $character->getLevel();
		$rangeResult = $character->getRange();
		$aliveResult = $character->getAlive();
		$factionResult = $character->getFactions();
		// Then
		$this->assertEquals("Ranged Fighter", $classResult);
		$this->assertEquals(1000, $healthResult);
		$this->assertEquals(1, $levelResult);
		$this->assertEquals(true, $aliveResult);
		$this->assertEquals(20, $rangeResult);
		$this->assertEquals(array(), $factionResult);
	}

	public function test_move_character()
	{
		// Given
		$character = new Character("Ranged Fighter");
		// When 
		$character->moveCharacter(array("x" => 15, "y" => 20));
		$character->moveCharacter(array("x" => -5, "y" => -5));
		$result = $character->getPosition();
		// Then
		$this->assertEquals(array("x" => 10, "y" => 15), $result);
	}

	public function test_calculate_distance()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$targetCharacter = new Character("Ranged Fighter");
		// When
		$character->moveCharacter(array("x" => 15, "y" => 20));
		$targetCharacter->moveCharacter(array("x" => 5, "y" => 10));
		$result = $character->CalculateDistance($targetCharacter->getPosition());
		// Then
		$this->assertEquals(20, $result);
	}

	public function test_calculate_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$result = $character->CalculateDamage();
		// Then
		$this->assertEquals(120, $result);
	}

	public function test_calculate_healing()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$result = $character->CalculateHealing();
		// Then
		$this->assertEquals(60, $result);
	}

	public function test_level_up()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$character->LevelUp();
		$character->LevelUp();
		$levelResult = $character->getLevel();
		$strenghtResult = $character->getStrenght();
		$intelligenceResult = $character->getIntelligence();
		// Then
		$this->assertEquals(3, $levelResult);
		$this->assertEquals(4, $strenghtResult);
		$this->assertEquals(4, $intelligenceResult);
	}

	public function test_character_targeteability_check()
	{
		// Given
		$character = new character("Ranged Fighter");
		$targeteableCharacter = new character("Ranged Fighter");
		$untargeteableTarget = new character("Ranged Fighter");
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		$character->DealDamage($untargeteableTarget);
		// When 
		$targeteableCharacterResult = $character->targeteabilityCheck($targeteableCharacter);
		$untargeteableTargetResult = $character->targeteabilityCheck($untargeteableTarget);
		// Then
		$this->assertEquals(true, $targeteableCharacterResult);
		$this->assertEquals(false, $untargeteableTargetResult);
		// Given
	}

	public function test_character_level_check()
	{
		// Given
		$character = new Character("Melee Fighter");
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();

		$lowerLvlTargetCharacter = new Character("Melee Fighter");

		$higherLvlTargetCharacter = new Character("Melee Fighter");
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();

		$similarLvlTargetCharacter = new Character("Melee Fighter");
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		// When 
		$target5lvlBelowCasterResult = $character->LevelCheck($character, $lowerLvlTargetCharacter);

		$target5lvlAboveCasterResult = $character->LevelCheck($character, $higherLvlTargetCharacter);

		$target5lvlWithinCasterResult = $character->LevelCheck($character, $similarLvlTargetCharacter);
		// Then
		$this->assertEquals(1.5, $target5lvlBelowCasterResult);

		$this->assertEquals(0.5, $target5lvlAboveCasterResult);

		$this->assertEquals(1, $target5lvlWithinCasterResult);
	}

	public function test_character_range_check()
	{
		// Given
		$character = new character("Ranged Fighter");
		$withinRangeDistance = array("x" => 15, "y" => -5);
		$notWithinRangeDistance = array("x" => -12, "y" => 9);
		// When 
		$withinRangeResult = $character->RangeCheck($character->getRange(), $withinRangeDistance);
		$notWithinnRangeResult = $character->RangeCheck($character->getRange(), $notWithinRangeDistance);
		// Then
		$this->assertEquals(true, $withinRangeResult);
		$this->assertEquals(false, $notWithinnRangeResult);
		// Given
	}

	public function test_character_can_join_factions()
	{
		// Given
		$character = new character("Ranged Fighter");
		// When 
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);
		$character->JoinFaction(4);
		$result = $character->getFactions();
		// Then
		$this->assertEquals(array(1, 2, 3, 4), $result);
	}

	public function test_character_can_leave_faction()
	{
		// Given
		$character = new character("Melee Fighter");
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);
		$character->JoinFaction(4);
		// When 
		$character->LeaveFaction(1);
		$character->LeaveFaction(2);
		$character->LeaveFaction(3);
		$character->LeaveFaction(4);
		$result = $character->getFactions();
		// Then
		$this->assertEquals(array(), $result);
	}

	public function test_character_same_faction_check()
	{
		// Given
		$character = new character("Ranged Fighter");
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);

		$sameFactionsTargetCharacter = new character("Ranged Fighter");
		$sameFactionsTargetCharacter->JoinFaction(1);
		$sameFactionsTargetCharacter->JoinFaction(2);

		$differentFactionsTargetCharacter = new character("Ranged Fighter");
		$differentFactionsTargetCharacter->JoinFaction(4);
		// When 
		$sameFactionResult = $character->SameFactionCheck($character, $sameFactionsTargetCharacter);

		$differentFactionResult = $character->SameFactionCheck($character, $differentFactionsTargetCharacter);
		// Then
		$this->assertEquals(true, $sameFactionResult);
		$this->assertEquals(false, $differentFactionResult);
	}

	public function test_character_deals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$targetCharacter = new Character("Ranged Fighter");
		// When 
		$character->DealDamage($targetCharacter);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(880, $result);
	}

	public function test_character_dies_after_being_dealt_damage()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$targetCharacter = new Character("Melee Fighter");
		// When 
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$character->DealDamage($targetCharacter);
		$aliveResult = $targetCharacter->getAlive();
		$healthResult = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(false, $aliveResult);
		$this->assertEquals(0, $healthResult);
	}

	public function test_character_cannot_damage_themselves()
	{
		// Given
		$character = new Character("Ranged Fighter");
		// When 
		$character->DealDamage($character);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	public function test_character_dealdamage_multiplier()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();

		$lowerLvlTargetCharacter = new Character("Melee Fighter");

		$higherLvlTargetCharacter = new Character("Melee Fighter");
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();
		$higherLvlTargetCharacter->LevelUp();

		$similarLvlTargetCharacter = new Character("Ranged Fighter");
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		$similarLvlTargetCharacter->LevelUp();
		// When 
		$character->DealDamage($lowerLvlTargetCharacter);
		$target5lvlBelowCasterResult = $lowerLvlTargetCharacter->getHealth();

		$character->DealDamage($higherLvlTargetCharacter);
		$target5lvlAboveCasterResult = $higherLvlTargetCharacter->getHealth();

		$character->DealDamage($similarLvlTargetCharacter);
		$target5lvlWithinCasterResult = $similarLvlTargetCharacter->getHealth();
		// Then
		$this->assertEquals(640, $target5lvlBelowCasterResult);

		$this->assertEquals(880, $target5lvlAboveCasterResult);

		$this->assertEquals(760, $target5lvlWithinCasterResult);
	}

	public function test_character_cannot_damage_same_faction_target()
	{
		// Given
		$character = new Character("Melee Fighter");
		$character->JoinFaction(1);
		$targetCharacter = new Character("Melee Fighter");
		$targetCharacter->JoinFaction(1);
		// When 
		$character->DealDamage($targetCharacter);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	public function test_character_heals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$aggressorCharacter = new Character("Melee Fighter");
		$aggressorCharacter->DealDamage($character);
		// When 
		$character->HealDamage($character);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(940, $result);
	}

	public function test_character_cannot_overheal()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$aggressorCharacter = new Character("Melee Fighter");
		$aggressorCharacter->DealDamage($character);
		// When
		$character->HealDamage($character);
		$character->HealDamage($character);
		$character->HealDamage($character);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	public function test_character_cannot_heal_others()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$targetCharacter = new Character("Melee Fighter");
		$character->DealDamage($targetCharacter);
		// When 
		$character->HealDamage($targetCharacter);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(880, $result);
	}

	public function test_character_healing_factions()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$character->JoinFaction(1);
		$characterDistance = 10;

		$sameFactionCharacter = new Character("Ranged Fighter");
		$sameFactionCharacter->JoinFaction(1);

		$differentFactionCharacter = new Character("Melee Fighter");
		$differentFactionCharacter->JoinFaction(2);
		$differentFactionCharacterDistance = 1;

		$differentFactionCharacter->DealDamage($sameFactionCharacter, $differentFactionCharacterDistance);
		$character->DealDamage($differentFactionCharacter, $characterDistance);
		// When 
		$character->HealDamage($sameFactionCharacter);
		$sameFactionResult = $sameFactionCharacter->getHealth();

		$character->HealDamage($differentFactionCharacter);
		$differentFactionResult = $differentFactionCharacter->getHealth();
		// Then
		$this->assertEquals(940, $sameFactionResult);
		$this->assertEquals(880, $differentFactionResult);
	}

	public function test_prop_can_be_created()
	{
		// Given
		$prop = new Prop(2000, array("x" => 0,"y" => 0,));
		// When
		$propHealthResult = $prop->getHealth();
		$propPositionResult = $prop->getPosition();
		// Then
		$this->assertEquals(2000, $propHealthResult);
		$this->assertEquals(array("x" => 0,"y" => 0,), $propPositionResult);
	}

	public function test_prop_can_be_attacked()
	{
		// Given
		$character = new Character("Melee Fighter");
		$targeteableProp = new Prop(2000, array("x" => 0,"y" => 0,));
		$nonTargeteableProp = new Prop(0, array("x" => 0,"y" => 0,));
		// When
		$character->DealDamage($targeteableProp);
		$targeteablePropResult = $targeteableProp->getHealth();

		$character->DealDamage($nonTargeteableProp);
		$nonTargeteablePropResult = $nonTargeteableProp->getHealth();
		// Then
		$this->assertEquals(1880, $targeteablePropResult);
		$this->assertEquals(0, $nonTargeteablePropResult);
	}

	public function test_prop_cannot_be_healed()
	{
		// Given
		$character = new Character("Melee Fighter");
		$prop = new Prop(2000, array("x" => 0,"y" => 0,));
		// When
		$character->HealDamage($prop);
		$result = $prop->getHealth();
		// Then
		$this->assertEquals(2000, $result);
	}

	public function test_prop_can_be_destroyed()
	{
		// Given
		$character = new Character("Melee Fighter");
		$prop = new Prop(200, array("x" => 0,"y" => 0,));
		// When
		$character->DealDamage($prop);
		$character->DealDamage($prop);
		$result = isset($prop);
		// Then
		$this->assertEquals(false, $result);
	}
}
