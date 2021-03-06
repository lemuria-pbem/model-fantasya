<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A precious gem.
 */
final class Gem extends AbstractLuxury
{
	private const VALUE = 8;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
