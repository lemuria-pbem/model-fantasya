<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Claymore;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A rusty claymore.
 */
final class RustyClaymore extends AbstractRepairable
{
	public function Weight(): int {
		return Claymore::WEIGHT;
	}

	public function Damage(): Damage {
		return $this->createDamage(Claymore::DAMAGE);
	}

	protected function craft(): string {
		return Weaponry::class;
	}

	protected function talent(): string {
		return Bladefighting::class;
	}

	protected function weapon(): string {
		return Claymore::class;
	}
}
