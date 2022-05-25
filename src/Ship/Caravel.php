<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Ship;

/**
 * A caravel.
 */
final class Caravel extends AbstractShip
{
	private const CAPTAIN = 4;

	private const CREW = 30;

	private const PAYLOAD = 3000 * 100;

	private const SPEED = 6;

	private const WOOD = 250;

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
