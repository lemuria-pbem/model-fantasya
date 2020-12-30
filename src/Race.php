<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

/**
 * The player races of Lemuria.
 * Each race has different special abilities.
 */
interface Race extends Transport
{
	/**
	 * Get the hitpoints of a person.
	 */
	#[Pure] public function Hitpoints(): int;

	/**
	 * Get the bonuses and maluses of talents.
	 */
	public function Modifications(): Knowledge;

	/**
	 * Get the recruiting cost for one person.
	 */
	#[Pure] public function Recruiting(): int;

	/**
	 * Get the weight of a person.
	 */
	#[Pure] public function Weight(): int;
}
