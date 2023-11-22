<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

/**
 * A galleon.
 */
final class Galleon extends AbstractShip
{
	private const int CAPTAIN = 6;

	private const int CREW = 80;

	private const int PAYLOAD = 6000 * 100;

	private const int SPEED = 4;

	private const int WOOD = 350;

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
