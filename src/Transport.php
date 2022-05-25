<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Commodity\Camel;
use Lemuria\Model\Fantasya\Commodity\Elephant;
use Lemuria\Model\Fantasya\Commodity\Griffin;
use Lemuria\Model\Fantasya\Commodity\Horse;
use Lemuria\Model\Fantasya\Commodity\Pegasus;
use Lemuria\Model\Fantasya\Commodity\Weapon\WarElephant;
use Lemuria\Singleton;

/**
 * Transports are vehicles that can carry units or cargo and be moved by a unit from region to region.
 */
interface Transport extends Singleton
{
	public final const ANIMALS = [Horse::class, Camel::class, Elephant::class, Pegasus::class, Griffin::class, WarElephant::class];

	/**
	 * Get the maximum weight of payload.
	 */
	public function Payload(): int;

	/**
	 * Get the speed when transporting.
	 */
	public function Speed(): int;
}
