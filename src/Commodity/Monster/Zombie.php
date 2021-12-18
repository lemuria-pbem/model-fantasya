<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class Zombie extends AbstractMonster
{
	private const HITPOINTS = 18;

	private const PAYLOAD = 5 * 100;

	private const WEIGHT = 5 * 100;

	public function __construct() {
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Swamp::class);
		$this->environment[] = self::createLandscape(Desert::class);
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
		return 0.0;
	}
}
