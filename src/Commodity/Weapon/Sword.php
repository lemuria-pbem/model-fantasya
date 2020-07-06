<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use Lemuria\Model\Lemuria\Commodity\Iron;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Bladefighting;
use Lemuria\Model\Lemuria\Talent\Weaponry;

/**
 * A sword.
 */
final class Sword extends AbstractWeapon
{
	private const WEIGHT = 1 * 100;

	private const IRON = 1;

	private const CRAFT = 2;

	/**
	 * Get the weight of a sword.
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
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/**
	 * Get the material.
	 *
	 * @return array(Commodity=>int)
	 */
	protected function material(): array {
		return [Iron::class => self::IRON];
	}

	/**
	 * Get the skill talent.
	 *
	 * @return string
	 */
	protected function talent(): string {
		return Bladefighting::class;
	}
}
