<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A spool of silk.
 */
final class Silk extends AbstractLuxury
{
	private const VALUE = 6;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
