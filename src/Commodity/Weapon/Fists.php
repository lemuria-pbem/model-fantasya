<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Fistfight;

/**
 * Fists are the default weapon of a unit that has no real weapon.
 */
final class Fists extends AbstractWeapon
{
	private const DAMAGE = [1, 5, 0];

	#[Pure] public function Weight(): int {
		return 0;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$fistfight = self::createTalent(Fistfight::class);
		return new Requirement($fistfight, 0);
	}

	#[Pure] protected function material(): array {
		return [];
	}

	#[Pure] protected function talent(): string {
		return Fistfight::class;
	}
}
