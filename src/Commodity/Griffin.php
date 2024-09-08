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

	private const int PAYLOAD = 50 * 100;

	private const int SPEED = 6;

	private const int WEIGHT = 120 * 100;

	private const int BLOCK = 1;

	private const int HITPOINTS = 30;

	private const float FLIGHT_CHANCE = 1.0;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [2, 5, 0];

	private const int SKILL = 5;

	private const string TROPHY = GriffinFeather::class;

	private const float RECREATION = 0.6;

	protected ?SingletonSet $loot = null;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE));
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
