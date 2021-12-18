<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Landscape\Swamp;

final class Ghoul extends AbstractMonster
{
	private const HITPOINTS = 15;

	private const PAYLOAD = 5 * 100;

	private const WEIGHT = 5 * 100;

	private const RECREATION = 0.5;

	public function __construct() {
		$this->environment[] = self::createLandscape(Swamp::class);
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
