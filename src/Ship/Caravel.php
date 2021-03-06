<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A caravel.
 */
final class Caravel extends AbstractShip
{
	private const CAPTAIN = 4;

	private const CREW = 30;

	private const PAYLOAD = 3000 * 100;

	private const SPEED = 6;

	private const WOOD = 250;

	#[Pure] public function Captain(): int {
		return self::CAPTAIN;
	}

	#[Pure] public function Crew(): int {
		return self::CREW;
	}

	#[Pure] public function Payload(): int {
		return self::PAYLOAD;
	}

	#[Pure] public function Speed(): int {
		return self::SPEED;
	}

	#[Pure] public function Wood(): int {
		return self::WOOD;
	}
}
