<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

/**
 * A small sack of olibanum.
 */
final class Olibanum extends AbstractLuxury
{
	private const VALUE = 4;

	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int {
		return self::VALUE;
	}
}
