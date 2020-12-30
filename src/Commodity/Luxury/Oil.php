<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A small barrel of oil.
 */
final class Oil extends AbstractLuxury
{
	private const VALUE = 3;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
