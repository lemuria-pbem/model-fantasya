<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A small sack of myrrh.
 */
final class Myrrh extends AbstractLuxury
{
	private const VALUE = 5;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
