<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Weapon\Bow;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Bowmaking;

/**
 * An ungirt bow.
 */
final class UngirtBow extends AbstractRepairable
{
	#[Pure] public function Weight(): int {
		return Bow::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return $this->createDamage(Bow::DAMAGE);
	}

	#[Pure] protected function craft(): string {
		return Bowmaking::class;
	}

	#[Pure] protected function talent(): string {
		return Archery::class;
	}

	#[Pure] protected function weapon(): string {
		return Bow::class;
	}
}
