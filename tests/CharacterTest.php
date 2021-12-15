<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use App\Character;
use App\MeleeFighter;
use App\RangedFighter;

class CharacterTest extends TestCase
{

	/** @test */

	public function character_health_is_1000()
	{
		// Given
		$character = new Character;
		// When 
		$result = $character->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_level_is_1()
	{
		// Given
		$character = new Character;
		// When 
		$result = $character->level;
		// Then
		$this->assertEquals(1, $result);
	}

	/** @test */

	public function character_alive_is_true()
	{
		// Given
		$character = new Character;
		// When 
		$result = $character->alive;
		// Then
		$this->assertEquals(true, $result);
	}

	/** @test */

	public function character_deals_damage()
	{
		// Given
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		$distance = 1;
		$damage = 600;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(2);
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
		$character->JoinFaction(1);
		$distance = 15;
		$damage = 1200;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(2);
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->alive;
		// Then
		$this->assertEquals(false, $result);
	}

	/** @test */

	public function character_heals_damage()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
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
		$character->JoinFaction(1);
		$heal = 600;
		$character->health = 500;
		// When 
		$character->HealDamage($character, $heal);
		$result = $character->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_cannot_damage_themselves()
	{
		// Given
		$character = new RangedFighter;
		$character->JoinFaction(1);
		$distance = 0;
		$damage = 300;
		// When 
		$character->DealDamage($character, $damage, $distance);
		$result = $character->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function character_cannot_heal_others()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
		$heal = 600;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(2);
		$targetCharacter->health = 250;
		// When 
		$character->HealDamage($targetCharacter, $heal);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(250, $result);
	}

	/** @test */

	public function character_level_check()
	{
		// Given
		$character = new RangedFighter;
		$character->level = 6;
		$targetCharacter1 = new Character;
		$targetCharacter1->level = 1;
		$targetCharacter2 = new Character;
		$targetCharacter2->level = 11;
		$targetCharacter3 = new Character;
		$targetCharacter3->level = 6;
		// When 
		$targetBelowCasterResult = $character->LevelCheck($character->level, $targetCharacter1->level);
		$targetAboveCasterResult = $character->LevelCheck($character->level, $targetCharacter2->level);
		$targetSimilarToCasterResult = $character->LevelCheck($character->level, $targetCharacter3->level);
		// Then
		$this->assertEquals(1.5, $targetBelowCasterResult);
		$this->assertEquals(0.75, $targetAboveCasterResult);
		$this->assertEquals(1, $targetSimilarToCasterResult);
	}

	/** @test */

	public function character_damage_multiplied_if_target_is_5_levels_or_more_below_the_attacker()
	{
		// Given
		$character = new RangedFighter;
		$character->JoinFaction(1);
		$character->level = 6;
		$distance = 20;
		$damage = 300;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(2);
		$targetCharacter->level = 1;
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(550, $result);
	}

	/** @test */

	public function character_damage_divided_if_target_is_5_levels_or_more_above_the_attacker()
	{
		// Given
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		$character->level = 1;
		$distance = 2;
		$damage = 600;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(2);
		$targetCharacter->level = 6;
		// When 
		$character->DealDamage($targetCharacter, $damage, $distance);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(550, $result);
	}

	/** @test */

	public function character_has_a_max_range()
	{
		// Given
		$character = new RangedFighter;
		// When 
		$result = $character->range;
		// Then
		$this->assertEquals(20, $result);
	}

	/** @test */

	public function character_range_check()
	{
		// Given
		$character = new RangedFighter;
		$distance = 10;
		// When 
		$result = $character->RangeCheck($character->range, $distance);
		// Then
		$this->assertEquals(true, $result);
	}

	/** @test */

	public function character_can_join_faction()
	{
		// Given
		$character = new MeleeFighter;
		// When 
		$character->JoinFaction(1);
		$result = $character->faction["factionOne"];
		// Then
		$this->assertEquals(1, $result);
	}

	/** @test */

	public function character_can_join_several_factions()
	{
		// Given
		$character = new MeleeFighter;
		// When 
		$character->JoinFaction(3);
		$character->JoinFaction(1);
		$result = $character->faction["factionThree"];
		// Then
		$this->assertEquals(1, $result);
	}

	/** @test */

	public function character_can_leave_faction()
	{
		// Given
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		// When 
		$character->LeaveFaction(1);
		$result = $character->faction["factionOne"];
		// Then
		$this->assertEquals(0, $result);
	}

	/** @test */

	public function character_same_faction_check()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(1);
		$character2 = new Character;
		$character2->JoinFaction(1);
		$targetCharacter2 = new Character;
		$targetCharacter2->JoinFaction(2);
		// When 
		$sameFaction = $character->SameFactionCheck($character->faction, $targetCharacter->faction);
		$differentFaction = $character2->SameFactionCheck($character2->faction, $targetCharacter2->faction);
		// Then
		$this->assertEquals(true, $sameFaction);
		$this->assertEquals(false, $differentFaction);
	}

	/** @test */

	public function character_cannot_damage_same_faction_target()
	{
		// Given
		$character = new MeleeFighter;
		$character->JoinFaction(1);
		$character->JoinFaction(2);
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

	public function character_can_heal_same_faction_members()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$heal = 800;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(1);
		$targetCharacter->health = 250;
		// When 
		$character->HealDamage($targetCharacter, $heal);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(1000, $result);
	}

	/** @test */

	public function prop_can_be_created()
	{
		// Given
		$character = new Character;
		$character->JoinFaction(1);
		$character->JoinFaction(2);
		$heal = 800;
		$targetCharacter = new Character;
		$targetCharacter->JoinFaction(1);
		$targetCharacter->health = 250;
		// When 
		$character->HealDamage($targetCharacter, $heal);
		$result = $targetCharacter->health;
		// Then
		$this->assertEquals(1000, $result);
	}

}
