<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A small sack of olibanum.
 */
final class Olibanum extends AbstractLuxury
{
	private const int VALUE = 5;

	public function Value(): int {
		return self::VALUE;
	}
}
