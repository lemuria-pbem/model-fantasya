<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Spear;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Spearfighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A stump spear.
 */
final class StumpSpear extends AbstractRepairable
{
	public function Weight(): int {
		return Spear::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Spear::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Spearfighting::class;
	}

	protected function weapon(): string {
		return Spear::class;
	}
}
