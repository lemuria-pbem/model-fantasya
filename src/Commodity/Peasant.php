<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * The Peasant.
 */
final class Peasant implements Commodity
{
	private const WEIGHT = 10 * 100;

	use SingletonTrait;

	/**
	 * Get the weight of a peasant.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}
}
