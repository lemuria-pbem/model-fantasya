<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

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
	private const HITPOINTS = 20;

	private const PAYLOAD = 5 * 100;

	private const WEIGHT = 5 * 100;

	private const TROPHY = Skull::class;

	public function __construct() {
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Desert::class);
		$this->environment[] = self::createLandscape(Mountain::class);
		$this->environment[] = self::createLandscape(Glacier::class);
	}

	#[Pure] public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	protected function getLoot(): array {
		return [
			Gold::class, Silver::class,
			AbstractLuxury::all(), AbstractPotion::all(), AbstractProtection::all(), AbstractWeapon::all(),
			RepairableWeapon::all(), RepairableProtection::all()
		];
	}

	#[Pure] public function Recreation(): float {
		return 0.0;
	}
}
