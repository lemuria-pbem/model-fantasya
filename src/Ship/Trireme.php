<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

/**
 * A trireme.
 */
final class Trireme extends AbstractShip
{
	private const int CAPTAIN = 5;

	private const int CREW = 120;

	private const int PAYLOAD = 2000 * 100;

	private const int SPEED = 8;

	private const int WOOD = 200;

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
