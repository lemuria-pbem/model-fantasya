<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A small sack of spices.
 */
final class Spice extends AbstractLuxury
{
	private const VALUE = 6;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
