<?php
/** @noinspection PhpIdempotentOperationInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

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
	public final const int WEIGHT = 1 * 100;

	/**
	 * @type array<int>
	 */
	public final const array DAMAGE = [1, 4, 4];

	private const int CRAFT = 2;

	private const int WOOD = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Bowmaking::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function talent(): string {
		return Archery::class;
	}
}
