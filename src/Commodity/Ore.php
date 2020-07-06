<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A pile of ore, the resource for iron.
 */
final class Ore implements Commodity
{
	private const WEIGHT = 15 * 100;

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
