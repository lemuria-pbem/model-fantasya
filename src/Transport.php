<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

use Lemuria\Singleton;

/**
 * A transport is a vehicle that can carry units or cargo and be moved by a unit from region to region.
 */
interface Transport extends Singleton
{
	/**
	 * Get the maximum weight of payload.
	 */
	#[Pure] public function Payload(): int;

	/**
	 * Get the speed when transporting.
	 */
	#[Pure] public function Speed(): int;
}
