<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Landscape\Glacier;
use Lemuria\Model\Fantasya\Monster;
use Lemuria\Model\Fantasya\MonsterTrait;
use Lemuria\Model\Fantasya\Commodity\Trophy\GriffinFeather;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;

/**
 * A griffin.
 */
final class Griffin implements Animal, Monster
{
	use BuilderTrait;
	use MonsterTrait;
	use SingletonTrait;

	private const PAYLOAD = 50 * 100;

	private const SPEED = 5;

	private const WEIGHT = 120 * 100;

	private const BLOCK = 1;

	private const HITPOINTS = 30;

	private const FLIGHT_CHANCE = 1.0;

	private const DAMAGE = [2, 5, 0];

	private const TROPHY = GriffinFeather::class;

	private const RECREATION = 0.6;

	protected ?SingletonSet $loot = null;

	public function __construct() {
		$this->weapon        = new NativeMelee(new Damage(...self::DAMAGE));
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Glacier::class);
	}

	public function Weight(): int {
		return self::WEIGHT;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	public function Block(): int {
		return self::BLOCK;
	}

	public function Hitpoints(): int {
		return self::HITPOINTS;
	}

	public function FlightChance(): float {
		return self::FLIGHT_CHANCE;
	}

	public function Loot(): SingletonSet {
		if (!$this->loot) {
			$this->loot = new SingletonSet();
		}
		return $this->loot;
	}

	public function Recreation(): float {
		return self::RECREATION;
	}
}
