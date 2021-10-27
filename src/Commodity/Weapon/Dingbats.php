<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Stoning;

/**
 * Dingbats are small stones used with the Stoning talent in last-resort distance combat.
 */
final class Dingbats extends AbstractWeapon
{
	private const DAMAGE = [1, 5, 0];

	#[Pure] public function Weight(): int {
		return 0;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$stoning = self::createTalent(Stoning::class);
		return new Requirement($stoning, 0);
	}

	#[Pure] protected function material(): array {
		return [];
	}

	#[Pure] protected function talent(): string {
		return Stoning::class;
	}
}
