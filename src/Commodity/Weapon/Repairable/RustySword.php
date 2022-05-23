<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Sword;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A rusty sword.
 */
final class RustySword extends AbstractRepairable
{
	public function Weight(): int {
		return Sword::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Sword::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Bladefighting::class;
	}

	protected function weapon(): string {
		return Sword::class;
	}
}
