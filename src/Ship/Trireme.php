<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A trireme.
 */
final class Trireme extends AbstractShip
{
	private const CAPTAIN = 5;

	private const CREW = 120;

	private const PAYLOAD = 2000 * 100;

	private const SPEED = 8;

	private const WOOD = 200;

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
