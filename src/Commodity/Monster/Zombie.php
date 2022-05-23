<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

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
