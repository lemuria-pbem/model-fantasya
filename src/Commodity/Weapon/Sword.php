<?php
/** @noinspection PhpIdempotentOperationInspection */
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Weapon;

use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Requirement;
use Lemuria\Model\Fantasya\Talent\Bladefighting;
use Lemuria\Model\Fantasya\Talent\Weaponry;

/**
 * A sword.
 */
final class Sword extends AbstractWeapon
{
	public final const int WEIGHT = 1 * 100;

	/**
	 * @type array<int>
	 */
	public final const array DAMAGE = [1, 8, 4];

	private const int IRON = 1;

	private const int CRAFT = 2;

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
		return [Iron::class => self::IRON];
	}

	protected function talent(): string {
		return Bladefighting::class;
	}
}
