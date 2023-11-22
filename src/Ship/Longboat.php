<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

/**
 * A longboat.
 */
final class Longboat extends AbstractShip
{
	private const int CAPTAIN = 2;

	private const int CREW = 10;

	private const int PAYLOAD = 500 * 100;

	private const int SPEED = 4;

	private const int WOOD = 50;

	public function Captain(): int {
		return self::CAPTAIN;
	}

	public function Crew(): int {
		return self::CREW;
	}

	public function Payload(): int {
		return self::PAYLOAD;
	}

	public function Speed(): int {
		return self::SPEED;
	}

	public function Wood(): int {
		return self::WOOD;
	}
}
