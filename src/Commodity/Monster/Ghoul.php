<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

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
