<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A galleon.
 */
final class Galleon extends AbstractShip
{
	private const CAPTAIN = 6;

	private const CREW = 80;

	private const PAYLOAD = 6000 * 100;

	private const SPEED = 4;

	private const WOOD = 350;

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
