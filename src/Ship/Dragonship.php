<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A dragonship.
 */
final class Dragonship extends AbstractShip
{
	private const CAPTAIN = 3;

	private const CREW = 50;

	private const PAYLOAD = 1000 * 100;

	private const SPEED = 5;

	private const WOOD = 100;

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
