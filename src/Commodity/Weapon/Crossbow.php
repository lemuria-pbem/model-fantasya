<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use Lemuria\Model\Lemuria\Commodity\Wood;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Bowmaking;
use Lemuria\Model\Lemuria\Talent\Crossbowing;

/**
 * A crossbow.
 */
final class Crossbow extends AbstractWeapon
{
	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

	private const CRAFT = 3;

	/**
	 * Get the weight of a bow.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Bowmaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/**
	 * Get the material.
	 *
	 * @return array(Commodity=>int)
	 */
	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	/**
	 * Get the skill talent.
	 *
	 * @return string
	 */
	protected function talent(): string {
		return Crossbowing::class;
	}
}
