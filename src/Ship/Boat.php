<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

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
