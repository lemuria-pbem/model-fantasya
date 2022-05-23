<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Warhammer;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A loose warhammer.
 */
final class LooseWarhammer extends AbstractRepairable
{
	public function Weight(): int {
		return Warhammer::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Warhammer::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Bladefighting::class;
	}

	protected function weapon(): string {
		return Warhammer::class;
	}
}
