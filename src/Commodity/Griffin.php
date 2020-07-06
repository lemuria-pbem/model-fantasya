<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Transport;
use Lemuria\SingletonTrait;

/**
 * A griffin.
 */
final class Griffin implements Commodity, Transport
{
	private const PAYLOAD = 50 * 100;

	private const SPEED = 5;

	private const WEIGHT = 120 * 100;

	use SingletonTrait;

	/**
	 * Get the weight of a peasant.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
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
}
