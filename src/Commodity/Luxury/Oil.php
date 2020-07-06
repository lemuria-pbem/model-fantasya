<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

/**
 * A small barrel of oil.
 */
final class Oil extends AbstractLuxury
{
	private const VALUE = 3;

	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int {
		return self::VALUE;
	}
}
