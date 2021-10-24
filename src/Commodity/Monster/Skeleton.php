<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Monster;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Trophy\Skull;

final class Skeleton extends AbstractMonster
{
	private const HITPOINTS = 20;

	private const PAYLOAD = 5 * 100;

	private const WEIGHT = 5 * 100;

	private const TROPHY = Skull::class;

	public function __construct() {
		$this->trophy = self::createTrophy(self::TROPHY);
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
