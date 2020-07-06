<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Singleton;

/**
 * A transport is a vehicle that can carry units or cargo and be moved by a unit from region to region.
 */
interface Transport extends Singleton
{
	/**
	 * Get the maximum weight of payload.
	 *
	 * @return int
	 */
	public function Payload(): int;

	/**
	 * Get the speed when transporting.
	 *
	 * @return int
	 */
	public function Speed(): int;
}
