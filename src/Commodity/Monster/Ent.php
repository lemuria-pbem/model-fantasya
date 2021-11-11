<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

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

	public function __construct() {
		$this->weapon        = new NativeMelee(new Damage(...self::DAMAGE), self::HITS);
		$this->environment[] = self::createLandscape(Forest::class);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Swamp::class);
	}

	#[Pure] public function Block(): int {
		return self::BLOCK;
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
}
