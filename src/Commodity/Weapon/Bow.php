<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity\Wood;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Archery;
use Lemuria\Model\Lemuria\Talent\Bowmaking;

/**
 * A bow.
 */
final class Bow extends AbstractWeapon
{
	private const CRAFT = 2;

	private const WEIGHT = 1 * 100;

	private const WOOD = 1;

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
		return Archery::class;
	}
}
