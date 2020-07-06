<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

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
