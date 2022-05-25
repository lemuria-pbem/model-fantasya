<?php
/** @noinspection PhpIdempotentOperationInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Spearfighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A spear.
 */
final class Spear extends AbstractWeapon
{
	public final const WEIGHT = 1 * 100;

	public final const DAMAGE = [1, 7, 3];

	private const WOOD = 1;

	private const CRAFT = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Damage(): Damage {
		return new Damage(...self::DAMAGE);
	}

	public function getCraft(): Requirement {
		$weaponry = self::createTalent(Weaponry::class);
		return new Requirement($weaponry, self::CRAFT);
	}

	protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	protected function talent(): string {
		return Spearfighting::class;
	}
}
