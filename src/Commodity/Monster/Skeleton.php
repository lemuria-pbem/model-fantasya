<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Gold;
use Lemuria\Model\Fantasya\Commodity\Luxury\AbstractLuxury;
use Lemuria\Model\Fantasya\Commodity\Potion\AbstractPotion;
use Lemuria\Model\Fantasya\Commodity\Protection\AbstractProtection;
use Lemuria\Model\Fantasya\Commodity\Protection\Repairable\AbstractRepairable as RepairableProtection;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Trophy\Skull;
use Lemuria\Model\Fantasya\Commodity\Weapon\AbstractWeapon;
use Lemuria\Model\Fantasya\Commodity\Weapon\Repairable\AbstractRepairable as RepairableWeapon;
use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Glacier;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;

final class Skeleton extends AbstractMonster
{
	private const int HITPOINTS = 20;

	private const int PAYLOAD = 5 * 100;

	private const int WEIGHT = 5 * 100;

	private const string TROPHY = Skull::class;

	public function __construct() {
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Desert::class);
		$this->environment[] = self::createLandscape(Mountain::class);
		$this->environment[] = self::createLandscape(Glacier::class);
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
			Gold::class, Silver::class,
			AbstractLuxury::all(), AbstractPotion::all(), AbstractProtection::all(), AbstractWeapon::all(),
			RepairableWeapon::all(), RepairableProtection::all()
		];
	}

	public function Recreation(): float {
		return 0.0;
	}
}
