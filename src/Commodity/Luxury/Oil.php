<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A small barrel of oil.
 */
final class Oil extends AbstractLuxury
{
	private const VALUE = 3;

	public function Value(): int {
		return self::VALUE;
	}
}
