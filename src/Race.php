<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * The player races of Lemuria.
 * Each race has different special abilities.
 */
interface Race extends Transport
{
	/**
	 * Get the hitpoints of a person.
	 */
	public function Hitpoints(): int;

	/**
	 * Get the flight chance of a person.
	 */
	public function FlightChance(): float;

	/**
	 * Get the hunger points of a healthy person.
	 */
	public function Hunger(): int;

	/**
	 * Get the Aura refill rate.
	 */
	public function Refill(): float;

	/**
	 * Get the bonuses and maluses of talents.
	 */
	public function Modifications(): Knowledge;

	/**
	 * Get the terrain effects.
	 */
	public function TerrainEffect(): TerrainEffect;

	/**
	 * Get the recruiting cost for one person.
	 */
	public function Recruiting(): int;

	/**
	 * Get the weight of a person.
	 */
	public function Weight(): int;
}
