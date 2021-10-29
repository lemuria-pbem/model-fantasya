<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Trophy\GoblinEar;
use Lemuria\Model\Fantasya\Landscape\Desert;
use Lemuria\Model\Fantasya\Landscape\Forest;
use Lemuria\Model\Fantasya\Landscape\Highland;
use Lemuria\Model\Fantasya\Landscape\Mountain;
use Lemuria\Model\Fantasya\Landscape\Plain;
use Lemuria\Model\Fantasya\Landscape\Swamp;

final class Goblin extends AbstractMonster
{
	private const HITPOINTS = 14;

	private const PAYLOAD = 3 * 100;

	private const WEIGHT = 6 * 100;

	private const TROPHY = GoblinEar::class;

	public function __construct() {
		$this->trophy        = self::createTrophy(self::TROPHY);
		$this->environment[] = self::createLandscape(Plain::class);
		$this->environment[] = self::createLandscape(Forest::class);
		$this->environment[] = self::createLandscape(Highland::class);
		$this->environment[] = self::createLandscape(Mountain::class);
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
}
