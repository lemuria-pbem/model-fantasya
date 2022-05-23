<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Bowmaking;
use Lemuria\Model\Fantasya\Talent\Crossbowing;

/**
 * A crossbow.
 */
final class Crossbow extends AbstractWeapon
{
	public final const WEIGHT = 2 * 100;

	private const DAMAGE = [2, 4, 6];

	private const WOOD = 1;

	private const CRAFT = 3;

	private const INTERVAL = 2;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function Interval(): int {
		return self::INTERVAL;
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Bowmaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function talent(): string {
		return Crossbowing::class;
	}
}
