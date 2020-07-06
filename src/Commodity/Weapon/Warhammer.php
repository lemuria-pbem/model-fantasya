<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use Lemuria\Model\Lemuria\Commodity\Iron;
use Lemuria\Model\Lemuria\Commodity\Wood;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Spearfighting;
use Lemuria\Model\Lemuria\Talent\Weaponry;

/**
 * A warhammer.
 */
final class Warhammer extends AbstractWeapon
{
	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

	private const IRON = 2;

	private const CRAFT = 5;

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
		return [Wood::class => self::WOOD, Iron::class => self::IRON];
	}

	/**
	 * Get the skill talent.
	 *
	 * @return string
	 */
	protected function talent(): string {
		return Spearfighting::class;
	}
}
