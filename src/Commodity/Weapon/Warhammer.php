<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A warhammer.
 */
final class Warhammer extends AbstractWeapon
{
	public final const WEIGHT = 2 * 100;

	public final const DAMAGE = [1, 8, 8];

	private const WOOD = 1;

	private const STONE = 1;

	private const IRON = 2;

	private const CRAFT = 4;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}

	#[Pure] protected function talent(): string {
		return Bladefighting::class;
	}
}
