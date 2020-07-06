<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

/**
 * A coat of animal.
 */
final class Fur extends AbstractLuxury
{
	private const VALUE = 7;

	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int {
		return self::VALUE;
	}
}
