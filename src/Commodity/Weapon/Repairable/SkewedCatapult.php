<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon\Repairable;

use Lemuria\Model\Fantasya\Commodity\Weapon\Catapult;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Talent\Catapulting;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;

/**
 * A skewed catapult.
 */
final class SkewedCatapult extends AbstractRepairable
{
	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [3, 7, 4];

	private const int HITS = 1;

	public function Weight(): int {
		return Catapult::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function Hits(): int {
		return self::HITS;
	}

	protected function craft(): string {
		return Carriagemaking::class;
	}

	protected function talent(): string {
		return Catapulting::class;
	}

	protected function weapon(): string {
		return Catapult::class;
	}
}
