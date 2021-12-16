<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\MeleeFighter;
use App\RangedFighter;

class CharacterTest extends TestCase
{

	public function MeleeFighter_correctly_created()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$classResult = $character->getClass();
		$healthResult = $character->getHealth();
		$levelResult = $character->getLevel();
		$rangeResult = $character->getRange();
		$aliveResult = $character->getAlive();
		$factionResult = $character->getFactions();
		// Then
		$this->assertEquals("Melee Fighter", $classResult);
		$this->assertEquals(1000, $healthResult);
		$this->assertEquals(1, $levelResult);
		$this->assertEquals(true, $aliveResult);
		$this->assertEquals(2, $rangeResult);
		$this->assertEquals(
			array(
				"factionOne" => 0,
				"factionTwo" => 0,
				"factionThree" => 0,
				"factionFour" => 0,
			),

			$factionResult
		);
	}

	/** @test */

	public function RangedFighter_correctly_created()
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
		$this->assertEquals(
			array(
				"factionOne" => 0,
				"factionTwo" => 0,
				"factionThree" => 0,
				"factionFour" => 0,
			),

			$factionResult
		);
	}

	/** @test */

	public function level_up()
	{
		// Given
		$character = new Character("Melee Fighter");
		// When 
		$character->LevelUp();
		$result = $character->getLevel();
		// Then
		$this->assertEquals(2, $result);
	}

	/** @test */

	public function character_level_check()
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
		$target5lvlBelowCasterResult = $character->LevelCheck($character->getLevel(), $lowerLvlTargetCharacter->getLevel());

		$target5lvlAboveCasterResult = $character->LevelCheck($character->getLevel(), $higherLvlTargetCharacter->getLevel());

		$target5lvlWithinCasterResult = $character->LevelCheck($character->getLevel(), $similarLvlTargetCharacter->getLevel());
		// Then
		$this->assertEquals(1.5, $target5lvlBelowCasterResult);

		$this->assertEquals(0.5, $target5lvlAboveCasterResult);

		$this->assertEquals(1, $target5lvlWithinCasterResult);
	}

	/** @test */

	public function character_range_check()
	{
		// Given
		$character = new character("Ranged Fighter");
		$withinRangeDistance = 10;
		$notWithinRangeDistance = 30;
		// When 
		$withinRangeResult = $character->RangeCheck($character->getRange(), $withinRangeDistance);
		$notWithinnRangeResult = $character->RangeCheck($character->getRange(), $notWithinRangeDistance);
		// Then
		$this->assertEquals(true, $withinRangeResult);
		$this->assertEquals(false, $notWithinnRangeResult);
	}

	/** @test */

	public function character_can_join_factions()
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
		$this->assertEquals(
			array(
				"factionOne" => 1,
				"factionTwo" => 1,
				"factionThree" => 1,
				"factionFour" => 1,
			),

			$result
		);
	}

	/** @test */

	public function character_can_leave_faction()
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
		$this->assertEquals(
			array(
				"factionOne" => 0,
				"factionTwo" => 0,
				"factionThree" => 0,
				"factionFour" => 0,
			),

			$result
		);
	}

	/** @test */

	public function character_same_faction_check()
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
		$sameFactionResult = $character->SameFactionCheck($character->getFactions(), $sameFactionsTargetCharacter->getFactions());
		
		$differentFactionResult = $character->SameFactionCheck($character->getFactions(), $differentFactionsTargetCharacter->getFactions());
		// Then
		$this->assertEquals(true, $sameFactionResult);
		$this->assertEquals(false, $differentFactionResult);
	}

	/** @test */

	public function character_deals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$distance = 1;
		$damage = 600;
		$targetCharacter = new Character("Ranged Fighter");
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(400, $result);
	}

	/** @test */

	public function character_dies_after_being_dealt_damage()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$distance = 15;
		$damage = 1200;
		$targetCharacter = new Character("Melee Fighter");
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$aliveResult = $targetCharacter->getAlive();
		$healthResult = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(false, $aliveResult);
		$this->assertEquals(0, $healthResult);
	}

	/** @test */

	public function character_cannot_damage_themselves()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$distance = 0;
		$damage = 300;
		// When 
		$character->DealDamage($character, $damage, $distance);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_dealdamage_multiplier()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$character->LevelUp();
		$distance = 5;
		$damage = 300;

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
		$character->DealDamage($lowerLvlTargetCharacter, $damage, $distance);
		$target5lvlBelowCasterResult = $lowerLvlTargetCharacter->getHealth();

		$character->DealDamage($higherLvlTargetCharacter, $damage, $distance);
		$target5lvlAboveCasterResult = $higherLvlTargetCharacter->getHealth();

		$character->DealDamage($similarLvlTargetCharacter, $damage, $distance);
		$target5lvlWithinCasterResult = $similarLvlTargetCharacter->getHealth();
		// Then
		$this->assertEquals(550, $target5lvlBelowCasterResult);

		$this->assertEquals(850, $target5lvlAboveCasterResult);

		$this->assertEquals(700, $target5lvlWithinCasterResult);
	}

	/** @test */

	public function character_cannot_damage_same_faction_target()
	{
		// Given
		$character = new Character("Melee Fighter");
		$character->JoinFaction(1);
		$distance = 1;
		$damage = 600;
		$targetCharacter = new Character("Melee Fighter");
		$targetCharacter->JoinFaction(1);
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_heals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$heal = 600;
		$aggressorCharacter = new Character("Melee Fighter");
		$distance = 1;
		$damage = 750;
		$aggressorCharacter->DealDamage($character, $damage, $distance);
		// When 
		$character->HealDamage($character, $heal);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(850, $result);
	}

	/** @test */

	public function character_cannot_overheal()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$heal = 600;
		$aggressorCharacter = new Character("Melee Fighter");
		$distance = 1;
		$damage = 500;
		$aggressorCharacter->DealDamage($character, $damage, $distance);
		// When
		$character->HealDamage($character, $heal);
		$result = $character->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_cannot_heal_others()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$distance = 20;
		$damage = 750;
		$heal = 600;
		$targetCharacter = new Character("Melee Fighter");
		$character->DealDamage($targetCharacter, $damage, $distance);
		// When 
		$character->HealDamage($targetCharacter, $heal);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(250, $result);
	}

	/** @test */

	public function character_healing_factions()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$character->JoinFaction(1);
		$distance = 10;
		$damage = 750;
		$heal = 800;

		$sameFactionCharacter = new Character("Ranged Fighter");
		$sameFactionCharacter->JoinFaction(1);

		$differentFactionCharacter = new Character("Melee Fighter");
		$differentFactionCharacter->JoinFaction(2);

		$character->DealDamage($sameFactionCharacter, $damage, $distance);
		$character->DealDamage($differentFactionCharacter, $damage, $distance);
		// When 
		$character->HealDamage($sameFactionCharacter, $heal);
		$sameFactionResult = $sameFactionCharacter->getHealth();
		
		$character->HealDamage($differentFactionCharacter, $heal);
		$differentFactionResult = $differentFactionCharacter->getHealth();
		// Then
		$this->assertEquals(1000, $sameFactionResult);
		$this->assertEquals(250, $differentFactionResult);
	}

	/** @test */

	// public function prop_can_be_created()
	// {
	// 	// Given
	// 	// When
	// 	// Then
	// }

}
