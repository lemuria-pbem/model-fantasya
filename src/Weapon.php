<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

/**
 * Weapons implement this interface.
 * Units must have a fighting talent to use a weapon in combat.
 */
interface Weapon extends Artifact
{
	/**
	 * Get the damage.
	 */
	#[Pure] public function Damage(): Damage;

	/**
	 * Get the needed skill for fighting with this weapon.
	 */
	public function getSkill(): Requirement;
}
