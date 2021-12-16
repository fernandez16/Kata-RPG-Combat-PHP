<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\MeleeFighter;
use App\RangedFighter;

class CharacterTest extends TestCase
{

	/** @test */

	public function character_correctly_created()
	{
		// Given
		$character = new Character;
		// When
		$healthResult = $character->health;
		$levelResult = $character->level;
		$aliveResult = $character->alive;
		$factionResult = $character->factions;
		// Then
		$this->assertEquals(1000, $healthResult);
		$this->assertEquals(1, $levelResult);
		$this->assertEquals(true, $aliveResult);
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
		$character = new RangedFighter;
		// When 
		$healthResult = $character->health;
		$levelResult = $character->level;
		$aliveResult = $character->alive;
		$factionResult = $character->factions;
		$rangeResult = $character->range;
		// Then
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

	public function MeleeFighter_correctly_created()
	{
		// Given
		$character = new MeleeFighter;
		// When 
		$healthResult = $character->health;
		$levelResult = $character->level;
		$aliveResult = $character->alive;
		$factionResult = $character->factions;
		$rangeResult = $character->range;
		// Then
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

	public function character_level_check()
	{
		// Given
		$character = new RangedFighter;
		$character->level = 6;

		$lowerLvlTargetCharacter = new Character;
		$lowerLvlTargetCharacter->level = 1;

		$higherLvlTargetCharacter = new Character;
		$higherLvlTargetCharacter->level = 11;

		$similarLvlTargetCharacter = new Character;
		$similarLvlTargetCharacter->level = 6;
		// When 
		$target5lvlBelowCasterResult = $character->LevelCheck($character->level, $lowerLvlTargetCharacter->level);

		$target5lvlAboveCasterResult = $character->LevelCheck($character->level, $higherLvlTargetCharacter->level);

		$target5lvlWithinCasterResult = $character->LevelCheck($character->level, $similarLvlTargetCharacter->level);
		// Then
		$this->assertEquals(1.5, $target5lvlBelowCasterResult);

		$this->assertEquals(0.5, $target5lvlAboveCasterResult);

		$this->assertEquals(1, $target5lvlWithinCasterResult);
	}

	/** @test */

	public function character_range_check()
	{
		// Given
		$character = new RangedFighter;
		$withinRangeDistance = 10;
		$notWithinRangeDistance = 30;
		// When 
		$withinRangeResult = $character->RangeCheck($character->range, $withinRangeDistance);
		$notWithinnRangeResult = $character->RangeCheck($character->range, $notWithinRangeDistance);
		// Then
		$this->assertEquals(true, $withinRangeResult);
		$this->assertEquals(false, $notWithinnRangeResult);
	}

	/** @test */

	public function character_can_join_factions()
	{
		// Given
		$character = new MeleeFighter;
		// When 
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);
		$character->JoinFaction(4);
		$result = $character->factions;
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
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);
		$character->JoinFaction(4);
		// When 
		$character->LeaveFaction(1);
		$character->LeaveFaction(2);
		$character->LeaveFaction(3);
		$character->LeaveFaction(4);
		$result = $character->factions;
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
		$character = new Character;
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$character->JoinFaction(3);

		$sameFactionsTargetCharacter = new Character;
		$sameFactionsTargetCharacter->JoinFaction(1);
		$sameFactionsTargetCharacter->JoinFaction(2);

		$differentFactionsTargetCharacter = new Character;
		$differentFactionsTargetCharacter->JoinFaction(4);
		// When 
		$sameFactionResult = $character->SameFactionCheck($character->factions, $sameFactionsTargetCharacter->factions);
		
		$differentFactionResult = $character->SameFactionCheck($character->factions, $differentFactionsTargetCharacter->factions);
		// Then
		$this->assertEquals(true, $sameFactionResult);
		$this->assertEquals(false, $differentFactionResult);
	}

	/** @test */

	public function character_deals_damage()
	{
		// Given
		$character = new MeleeFighter;
		$distance = 1;
		$damage = 600;
		$targetCharacter = new Character;
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(400, $result);
	}

	/** @test */

	public function character_dies_after_being_dealt_damage()
	{
		// Given
		$character = new RangedFighter;
		$distance = 15;
		$damage = 1200;
		$targetCharacter = new Character;
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$aliveResult = $targetCharacter->alive;
		$healthResult = $targetCharacter->health;
		// Then
		$this->assertEquals(false, $aliveResult);
		$this->assertEquals(0, $healthResult);
	}

	/** @test */

	public function character_cannot_damage_themselves()
	{
		// Given
		$character = new RangedFighter;
		$distance = 0;
		$damage = 300;
		// When 
		$character->DealDamage($character, $damage, $distance);
		$result = $character->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_dealdamage_multiplier()
	{
		// Given
		$character = new RangedFighter;
		$character->level = 6;
		$distance = 5;
		$damage = 300;

		$lowerLvlTargetCharacter = new Character;
		$lowerLvlTargetCharacter->level = 1;

		$higherLvlTargetCharacter = new Character;
		$higherLvlTargetCharacter->level = 11;

		$similarLvlTargetCharacter = new Character;
		$similarLvlTargetCharacter->level = 6;
		// When 
		$character->DealDamage($lowerLvlTargetCharacter, $damage, $distance);
		$target5lvlBelowCasterResult = $lowerLvlTargetCharacter->health;

		$character->DealDamage($higherLvlTargetCharacter, $damage, $distance);
		$target5lvlAboveCasterResult = $higherLvlTargetCharacter->health;

		$character->DealDamage($similarLvlTargetCharacter, $damage, $distance);
		$target5lvlWithinCasterResult = $similarLvlTargetCharacter->health;
		// Then
		$this->assertEquals(550, $target5lvlBelowCasterResult);

		$this->assertEquals(850, $target5lvlAboveCasterResult);

		$this->assertEquals(700, $target5lvlWithinCasterResult);
	}

	/** @test */

	public function character_cannot_damage_same_faction_target()
	{
		// Given
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		$distance = 1;
		$damage = 600;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(1);
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_heals_damage()
	{
		// Given
		$character = new Character;
		$heal = 600;
		$character->health = 250;
		// When 
		$character->HealDamage($character, $heal);
		$result = $character->health;
		// Then
		$this->assertEquals(850, $result);
	}

	/** @test */

	public function character_cannot_overheal()
	{
		// Given
		$character = new Character;
		$heal = 600;
		$character->health = 500;
		// When 
		$character->HealDamage($character, $heal);
		$result = $character->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_cannot_heal_others()
	{
		// Given
		$character = new Character;
		$heal = 600;
		$targetCharacter = new Character;
		$targetCharacter->health = 250;
		// When 
		$character->HealDamage($targetCharacter, $heal);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(250, $result);
	}

	/** @test */

	public function character_healing_factions()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
		$heal = 800;

		$sameFactionCharacter = new Character;
		$sameFactionCharacter->JoinFaction(1);
		$sameFactionCharacter->health = 250;

		$differentFactionCharacter = new Character;
		$differentFactionCharacter->JoinFaction(2);
		$differentFactionCharacter->health = 250;
		// When 
		$character->HealDamage($sameFactionCharacter, $heal);
		$sameFactionResult = $sameFactionCharacter->health;
		
		$character->HealDamage($differentFactionCharacter, $heal);
		$differentFactionResult = $differentFactionCharacter->health;
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
