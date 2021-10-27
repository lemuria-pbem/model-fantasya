<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;

/**
 * Common base class for native weapons.
 */
abstract class Native extends AbstractWeapon
{
	public function __construct(protected Damage $damage, protected int $hits = 1) {
	}

	#[Pure] public function Weight(): int {
		return 0;
	}

	#[Pure] public function Hits(): int {
		return $this->hits;
	}

	#[Pure] public function Damage(): Damage {
		return $this->damage;
	}

	public function getCraft(): Requirement {
		$fistfight = self::createTalent($this->talent());
		return new Requirement($fistfight, 0);
	}

	#[Pure] protected function material(): array {
		return [];
	}
}
