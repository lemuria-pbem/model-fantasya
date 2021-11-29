<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Weapon\Crossbow;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Crossbowing;
use Lemuria\Model\Fantasya\Talent\Bowmaking;

/**
 * An ungirt crossbow.
 */
final class UngirtCrossbow extends AbstractRepairable
{
	private const DAMAGE = [1, 4, 6];

	#[Pure] public function Weight(): int {
		return Crossbow::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	#[Pure] protected function craft(): string {
		return Bowmaking::class;
	}

	#[Pure] protected function talent(): string {
		return Crossbowing::class;
	}

	#[Pure] protected function weapon(): string {
		return Crossbow::class;
	}
}
