<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Fistfight;

/**
 * Fists are the default weapon of a unit that has no real weapon.
 */
final class Fists extends AbstractWeapon
{
	/**
	 * Fists have no weight.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return 0;
	}

	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement {
		$fistfight = self::createTalent(Fistfight::class);
		return new Requirement($fistfight, 1);
	}

	/**
	 * Get the material.
	 *
	 * @return array(string=>int)
	 */
	protected function material(): array {
		return [];
	}

	/**
	 * Get the skill talent.
	 *
	 * @return string
	 */
	protected function talent(): string {
		return Fistfight::class;
	}
}
