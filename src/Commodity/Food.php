<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A food ration for one person and round.
 */
final class Food implements Commodity
{
	public const PRICE = 10;

	private const WEIGHT = 10;

	use SingletonTrait;

	/**
	 * Get the weight of a food ration.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * Get the standard price of a food ration.
	 *
	 * @return int
	 */
	public function Price(): int {
		return self::PRICE;
	}
}
