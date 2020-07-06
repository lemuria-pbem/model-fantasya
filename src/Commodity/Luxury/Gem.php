<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

/**
 * A precious gem.
 */
final class Gem extends AbstractLuxury
{
	private const VALUE = 8;

	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int {
		return self::VALUE;
	}
}
