<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Gold;
use Lemuria\Model\Fantasya\Commodity\Herb\AbstractHerb;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Luxury\AbstractLuxury;
use Lemuria\Model\Fantasya\Commodity\Potion\AbstractPotion;
use Lemuria\Model\Fantasya\Commodity\Protection\AbstractProtection;
use Lemuria\Model\Fantasya\Commodity\Protection\Repairable\AbstractRepairable as RepairableProtection;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Trophy\GoblinEar;
use Lemuria\Model\Fantasya\Commodity\Weapon\AbstractWeapon;
use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Commodity\Weapon\Repairable\AbstractRepairable as RepairableWeapon;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;
use Lemuria\Model\Fantasya\Raiseable;
use Lemuria\Model\Fantasya\UndeadTrait;

final class Goblin extends AbstractMonster implements Raiseable
{
	use UndeadTrait;

	private const int HITPOINTS = 14;

	private const int PAYLOAD = 3 * 100;

	private const int WEIGHT = 6 * 100;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 2, 0];

	private const int SKILL = 1;

	private const string TROPHY = GoblinEar::class;

	private const float RECREATION = 1.0;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE));
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Forest::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Mountain::class);
		$this->environment[] = self::createLandscape(Swamp::class);
		$this->environment[] = self::createLandscape(Desert::class);
	}

	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getLoot(): array {
		return [
			Gold::class, Iron::class, Silver::class,
			AbstractHerb::all(), AbstractLuxury::all(), AbstractPotion::all(), AbstractProtection::all(), AbstractWeapon::all(),
			RepairableWeapon::all(), RepairableProtection::all()
		];
	}

	public function Recreation(): float {
		return self::RECREATION;
	}
}
