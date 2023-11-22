<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

/**
 * A small boat.
 */
final class Boat extends AbstractShip
{
	private const int CAPTAIN = 1;

	private const int CREW = 2;

	private const int PAYLOAD = 50 * 100;

	private const int SPEED = 2;

	private const int WOOD = 5;

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
