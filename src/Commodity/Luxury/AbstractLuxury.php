<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

use Lemuria\Model\Lemuria\Luxury;
use Lemuria\SingletonTrait;

/**
 * Base class for any luxury.
 */
abstract class AbstractLuxury implements Luxury
{
	use SingletonTrait;

	private const WEIGHT = 1 * 100;

	/**
	 * Get the weight of a peasant.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}
}
