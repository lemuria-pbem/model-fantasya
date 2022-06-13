<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Carriagemaking;
use Lemuria\Model\Fantasya\Talent\Catapulting;

/**
 * A catapult.
 */
final class Catapult extends AbstractWeapon
{
	public final const WEIGHT = 100 * 100;

	private const DAMAGE = [3, 10, 5];

	private const WOOD = 10;

	private const CRAFT = 3;

	private const HITS = 3;

	private const INTERVAL = 5;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function Hits(): int {
		return self::HITS;
	}

	public function Interval(): int {
		return self::INTERVAL;
	}

	public function getCraft(): Requirement {
		$carriagemaking = self::createTalent(Carriagemaking::class);
		return new Requirement($carriagemaking, self::CRAFT);
	}

	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function talent(): string {
		return Catapulting::class;
	}
}
