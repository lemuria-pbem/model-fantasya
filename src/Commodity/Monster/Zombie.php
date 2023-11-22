<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class Zombie extends AbstractMonster
{
	private const int HITPOINTS = 18;

	private const int PAYLOAD = 5 * 100;

	private const int WEIGHT = 5 * 100;

	private const int HITS = 1;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 3, 0];

	private const int SKILL = 1;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE), self::HITS);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Highland::class);
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

	public function Recreation(): float {
		return 0.0;
	}
}
