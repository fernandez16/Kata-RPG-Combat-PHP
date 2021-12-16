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
		$target5lvlBelowCasterResult = $character->LevelCheck($character->getLevel(), $lowerLvlTargetCharacter->getLevel());

		$target5lvlAboveCasterResult = $character->LevelCheck($character->getLevel(), $higherLvlTargetCharacter->getLevel());

		$target5lvlWithinCasterResult = $character->LevelCheck($character->getLevel(), $similarLvlTargetCharacter->getLevel());
		// Then
		$this->assertEquals(1.5, $target5lvlBelowCasterResult);

		$this->assertEquals(0.5, $target5lvlAboveCasterResult);

		$this->assertEquals(1, $target5lvlWithinCasterResult);
	}

	public function test_character_range_check()
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
		$sameFactionResult = $character->SameFactionCheck($character->getFactions(), $sameFactionsTargetCharacter->getFactions());
		
		$differentFactionResult = $character->SameFactionCheck($character->getFactions(), $differentFactionsTargetCharacter->getFactions());
		// Then
		$this->assertEquals(true, $sameFactionResult);
		$this->assertEquals(false, $differentFactionResult);
	}

	public function test_character_deals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$distance = 1;
		$targetCharacter = new Character("Ranged Fighter");
		// When 
		$character->DealDamage($targetCharacter, $distance);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(880, $result);
	}

	public function test_character_dies_after_being_dealt_damage()
	{
		// Given
		$character = new Character("Ranged Fighter");
		$distance = 15;
		$targetCharacter = new Character("Melee Fighter");
		// When 
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
		$character->DealDamage($targetCharacter, $distance);
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
		$distance = 0;
		// When 
		$character->DealDamage($character, $distance);
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
		$distance = 5;

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
		$character->DealDamage($lowerLvlTargetCharacter, $distance);
		$target5lvlBelowCasterResult = $lowerLvlTargetCharacter->getHealth();

		$character->DealDamage($higherLvlTargetCharacter, $distance);
		$target5lvlAboveCasterResult = $higherLvlTargetCharacter->getHealth();

		$character->DealDamage($similarLvlTargetCharacter, $distance);
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
		$distance = 1;
		$targetCharacter = new Character("Melee Fighter");
		$targetCharacter->JoinFaction(1);
		// When 
		$character->DealDamage($targetCharacter, $distance);
		$result = $targetCharacter->getHealth();
		// Then
		$this->assertEquals(1000, $result);
	}

	public function test_character_heals_damage()
	{
		// Given
		$character = new Character("Melee Fighter");
		$aggressorCharacter = new Character("Melee Fighter");
		$distance = 1;
		$aggressorCharacter->DealDamage($character, $distance);
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
		$distance = 1;
		$aggressorCharacter->DealDamage($character, $distance);
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
		$distance = 20;
		$targetCharacter = new Character("Melee Fighter");
		$character->DealDamage($targetCharacter, $distance);
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

	// test_public function prop_can_be_created()
	// {
	// 	// Given
	// 	// When
	// 	// Then
	// }

}
