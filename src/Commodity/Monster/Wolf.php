<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Trophy\WolfSkin;
use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;

final class Wolf extends AbstractMonster
{
	private const int HITPOINTS = 28;

	private const int PAYLOAD = 2 * 100;

	private const int WEIGHT = 10 * 100;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 4, 1];

	private const int SKILL = 3;

	private const string TROPHY = WolfSkin::class;

	private const float RECREATION = 0.6;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE));
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Forest::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Mountain::class);
		$this->environment[] = self::createLandscape(Plain::class);
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

	public function Recreation(): float {
		return self::RECREATION;
	}
}
