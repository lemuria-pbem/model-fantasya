<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

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
	public const WEIGHT = 100 * 100;

	private const DAMAGE = [3, 10, 5];

	private const WOOD = 10;

	private const CRAFT = 3;

	private const HITS = 3;

	private const INTERVAL = 5;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	#[Pure] public function Hits(): int {
		return self::HITS;
	}

	#[Pure] public function Interval(): int {
		return self::INTERVAL;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Carriagemaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	#[Pure] protected function talent(): string {
		return Catapulting::class;
	}
}
