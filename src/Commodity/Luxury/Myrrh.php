<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A small sack of myrrh.
 */
final class Myrrh extends AbstractLuxury
{
	private const VALUE = 5;

	public function Value(): int {
		return self::VALUE;
	}
}
