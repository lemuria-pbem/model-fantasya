<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use Lemuria\Model\Fantasya\Commodity\Weapon\NativeMelee;
use Lemuria\Model\Fantasya\Damage;
use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class Ent extends AbstractMonster
{
	private const BLOCK = 3;

	private const HITPOINTS = 450;

	private const PAYLOAD = 100 * 100;

	private const WEIGHT = 240 * 100;

	private const HITS = 2;

	private const DAMAGE = [3, 5, 3];

	private const SKILL = 4;

	private const RECREATION = 0.1;

	public function __construct() {
		$this->weapon        = new NativeMelee(self::SKILL, new Damage(...self::DAMAGE), self::HITS);
		$this->environment[] = self::createLandscape(Forest::class);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Swamp::class);
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
