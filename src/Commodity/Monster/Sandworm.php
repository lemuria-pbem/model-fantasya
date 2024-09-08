<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Trophy\EbonyTooth;
use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Desert;

final class Sandworm extends AbstractMonster
{
	private const int BLOCK = 5;

	private const int HITPOINTS = 2500;

	private const int PAYLOAD = 150 * 100;

	private const int WEIGHT = 600 * 100;

	private const int HITS = 6;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [4, 7, 4];

	private const int SKILL = 8;

	private const string TROPHY = EbonyTooth::class;

	private const float FLIGHT_CHANCE = 1.0;

	private const float RECREATION = 0.4;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE), self::HITS);
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Desert::class);
	}

	public function Block(): int {
		return self::BLOCK;
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

	public function FlightChance(): float {
		return self::FLIGHT_CHANCE;
	}

	public function Recreation(): float {
		return self::RECREATION;
	}
}
