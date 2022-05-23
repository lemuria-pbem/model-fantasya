<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * Weapons implement this interface.
 * Units must have a fighting talent to use a weapon in combat.
 */
interface Weapon extends Artifact
{
	/**
	 * Get the damage.
	 */
	public function Damage(): Damage;

	/**
	 * Get the number of hits.
	 */
	public function Hits(): int;

	/**
	 * Get the interval between two attacks with this weapon.
	 */
	public function Interval(): int;

	/**
	 * Get the needed skill for fighting with this weapon.
	 */
	public function getSkill(): Requirement;
}
