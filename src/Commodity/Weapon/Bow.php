<?php
/** @noinspection PhpIdempotentOperationInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Archery;
use Lemuria\Model\Fantasya\Talent\Bowmaking;

/**
 * A bow.
 */
final class Bow extends AbstractWeapon
{
	public const WEIGHT = 1 * 100;

	public const DAMAGE = [1, 4, 4];

	private const CRAFT = 2;

	private const WOOD = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Bowmaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	#[Pure] protected function talent(): string {
		return Archery::class;
	}
}
