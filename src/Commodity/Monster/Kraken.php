<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

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

	private const RECREATION = 0.4;

	public function __construct() {
		$this->weapon        = new NativeMelee(new Damage(...self::DAMAGE), self::HITS);
		$this->environment[] = self::createLandscape(Ocean::class);
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

	#[Pure] public function Recreation(): float {
		return self::RECREATION;
	}
}
