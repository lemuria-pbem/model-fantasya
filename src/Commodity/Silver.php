<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A silver coin.
 */
final class Silver implements Commodity
{
	private const WEIGHT = 1;

	use SingletonTrait;

	/**
	 * Get the weight of a silver coin.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}
}
