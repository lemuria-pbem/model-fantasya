<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Fistfight;

/**
 * Fists are the default weapon of a unit that has no real weapon.
 */
final class Fists extends AbstractWeapon
{
	#[Pure] public function Weight(): int {
		return 0;
	}

	public function getCraft(): Requirement {
		$fistfight = self::createTalent(Fistfight::class);
		return new Requirement($fistfight, 1);
	}

	#[Pure] protected function material(): array {
		return [];
	}

	#[Pure] protected function talent(): string {
		return Fistfight::class;
	}
}
