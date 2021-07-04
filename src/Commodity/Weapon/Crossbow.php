<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Bowmaking;
use Lemuria\Model\Fantasya\Talent\Crossbowing;

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

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	#[Pure] protected function talent(): string {
		return Crossbowing::class;
	}
}
