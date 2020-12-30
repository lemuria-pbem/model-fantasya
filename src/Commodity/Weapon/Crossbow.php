<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

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

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Bowmaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	#[Pure] protected function talent(): string {
		return Crossbowing::class;
	}
}
