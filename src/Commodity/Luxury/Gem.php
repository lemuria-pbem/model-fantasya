<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A precious gem.
 */
final class Gem extends AbstractLuxury
{
	private const int VALUE = 8;

	public function Value(): int {
		return self::VALUE;
	}
}
