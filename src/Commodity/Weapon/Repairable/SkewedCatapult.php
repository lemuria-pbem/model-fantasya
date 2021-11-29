<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Weapon\Catapult;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;

/**
 * A skewed catapult.
 */
final class SkewedCatapult extends AbstractRepairable
{
	private const DAMAGE = [3, 7, 4];

	private const HITS = 1;

	#[Pure] public function Weight(): int {
		return Catapult::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	#[Pure] public function Hits(): int {
		return self::HITS;
	}

	#[Pure] protected function craft(): string {
		return Carriagemaking::class;
	}

	#[Pure] protected function talent(): string {
		return Catapulting::class;
	}

	#[Pure] protected function weapon(): string {
		return Catapult::class;
	}
}
