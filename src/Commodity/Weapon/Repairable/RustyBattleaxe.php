<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Battleaxe;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A rusty battleaxe.
 */
final class RustyBattleaxe extends AbstractRepairable
{
	public function Weight(): int {
		return Battleaxe::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Battleaxe::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Bladefighting::class;
	}

	protected function weapon(): string {
		return Battleaxe::class;
	}
}
