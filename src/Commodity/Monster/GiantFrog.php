<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class GiantFrog extends AbstractMonster
{
	private const int HITPOINTS = 25;

	private const int PAYLOAD = 1 * 100;

	private const int WEIGHT = 7 * 100;

	private const float RECREATION = 0.7;

	private const int SKILL = 8;

	/**
	 * @type array<int>
	 */
	private const array DAMAGE = [1, 5, 2];

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE));
		$this->environment[] = self::createLandscape(Swamp::class);
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
