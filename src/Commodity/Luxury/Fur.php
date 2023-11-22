<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A coat of animal.
 */
final class Fur extends AbstractLuxury
{
	private const int VALUE = 7;

	public function Value(): int {
		return self::VALUE;
	}
}
