<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A small boat.
 */
final class Boat extends AbstractShip
{
	private const CAPTAIN = 1;

	private const CREW = 2;

	private const PAYLOAD = 50 * 100;

	private const SPEED = 2;

	private const WOOD = 5;

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
