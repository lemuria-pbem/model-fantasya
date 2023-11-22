<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

/**
 * A spool of silk.
 */
final class Silk extends AbstractLuxury
{
	private const int VALUE = 6;

	public function Value(): int {
		return self::VALUE;
	}
}
