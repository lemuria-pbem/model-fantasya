<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

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
