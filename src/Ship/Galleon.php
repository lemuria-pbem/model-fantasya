<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

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

	/**
	 * Get the minimum total sailing ability to sail the ship.
	 *
	 * @return int
	 */
	public function Captain(): int {
		return self::CAPTAIN;
	}

	/**
	 * Get the minimum total sailing ability to sail the ship.
	 *
	 * @return int
	 */
	public function Crew(): int {
		return self::CREW;
	}

	/**
	 * Get the maximum weight of payload.
	 *
	 * @return int
	 */
	public function Payload(): int {
		return self::PAYLOAD;
	}

	/**
	 * Get the speed when transporting.
	 *
	 * @return int
	 */
	public function Speed(): int {
		return self::SPEED;
	}

	/**
	 * Get the amount of wood.
	 *
	 * @return int
	 */
	protected function wood(): int {
		return self::WOOD;
	}
}
