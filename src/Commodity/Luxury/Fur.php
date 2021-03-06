<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A coat of animal.
 */
final class Fur extends AbstractLuxury
{
	private const VALUE = 7;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
