<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A small barrel of balsam.
 */
final class Balsam extends AbstractLuxury
{
	private const VALUE = 4;

	public function Value(): int {
		return self::VALUE;
	}
}
