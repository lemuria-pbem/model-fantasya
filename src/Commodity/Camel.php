<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Transport;
use Lemuria\SingletonTrait;

/**
 * A camel.
 */
final class Camel implements Commodity, Transport
{

	private const PAYLOAD = 40 * 100;

	private const SPEED = 1;

	private const WEIGHT = 50 * 100;

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
