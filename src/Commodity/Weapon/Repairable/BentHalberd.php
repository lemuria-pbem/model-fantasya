<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Halberd;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Spearfighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A bent halberd.
 */
final class BentHalberd extends AbstractRepairable
{
	public function Weight(): int {
		return Halberd::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Halberd::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Spearfighting::class;
	}

	protected function weapon(): string {
		return Halberd::class;
	}
}
