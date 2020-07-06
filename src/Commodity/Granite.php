<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A granite rock, the resource for stones.
 */
final class Granite implements Commodity
{
	private const WEIGHT = 100 * 100;

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
