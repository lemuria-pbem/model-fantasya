<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

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

	public function Weight(): int {
		return Crossbow::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	protected function craft(): string {
		return Bowmaking::class;
	}

	protected function talent(): string {
		return Crossbowing::class;
	}

	protected function weapon(): string {
		return Crossbow::class;
	}
}
