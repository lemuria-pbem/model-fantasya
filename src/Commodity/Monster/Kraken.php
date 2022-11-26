<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Ocean;

final class Kraken extends AbstractMonster
{
	private const BLOCK = 0;

	private const HITPOINTS = 130;

	private const PAYLOAD = 100 * 100;

	private const WEIGHT = 320 * 100;

	private const HITS = 2;

	private const DAMAGE = [2, 10, 3];

	private const SKILL = 3;

	private const RECREATION = 0.4;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE), self::HITS);
		$this->environment[] = self::createLandscape(Ocean::class);
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

	public function Recreation(): float {
		return self::RECREATION;
	}
}
