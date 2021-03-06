<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

use JetBrains\PhpStorm\Pure;

/**
 * A longboat.
 */
final class Longboat extends AbstractShip
{
	private const CAPTAIN = 2;

	private const CREW = 10;

	private const PAYLOAD = 500 * 100;

	private const SPEED = 4;

	private const WOOD = 50;

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
