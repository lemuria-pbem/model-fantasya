<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * The player races of Lemuria.
 *
 * Each race has different special abilities.
 */
interface Race extends Transport
{
	/**
	 * Get the hitpoints of a person.
	 *
	 * @return int
	 */
	public function Hitpoints(): int;

	/**
	 * Get the bonuses and maluses of talents.
	 *
	 * @return Knowledge
	 */
	public function Modifications(): Knowledge;

	/**
	 * Get the recruiting cost for one person.
	 *
	 * @return int
	 */
	public function Recruiting(): int;

	/**
	 * Get the weight of a person.
	 *
	 * @return int
	 */
	public function Weight(): int;
}
