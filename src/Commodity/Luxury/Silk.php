<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

/**
 * A spool of silk.
 */
final class Silk extends AbstractLuxury
{
	private const VALUE = 6;

	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int {
		return self::VALUE;
	}
}
