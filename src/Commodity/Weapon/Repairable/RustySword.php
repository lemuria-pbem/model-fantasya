<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Weapon\Sword;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A rusty sword.
 */
final class RustySword extends AbstractRepairable
{
	#[Pure] public function Weight(): int {
		return Sword::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return $this->createDamage(Sword::DAMAGE);
	}

	#[Pure] protected function craft(): string {
		return Weaponry::class;
	}

	#[Pure] protected function talent(): string {
		return Bladefighting::class;
	}

	#[Pure] protected function weapon(): string {
		return Sword::class;
	}
}