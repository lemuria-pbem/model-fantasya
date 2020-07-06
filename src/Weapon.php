<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * Weapons implement this interface.
 * Units must have a fighting talent to use a weapon in combat.
 */
interface Weapon extends Artifact
{
	/**
	 * Get the needed skill for fighting with this weapon.
	 *
	 * @return Requirement
	 */
	public function getSkill(): Requirement;
}
