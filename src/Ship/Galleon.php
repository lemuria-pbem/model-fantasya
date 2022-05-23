<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

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
