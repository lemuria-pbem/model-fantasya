<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Bow;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Bowmaking;

/**
 * An ungirt bow.
 */
final class UngirtBow extends AbstractRepairable
{
	public function Weight(): int {
		return Bow::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Bow::DAMAGE);
	}

	protected function craft(): string {
		return Bowmaking::class;
	}

	protected function talent(): string {
		return Archery::class;
	}

	protected function weapon(): string {
		return Bow::class;
	}
}
