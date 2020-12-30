<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A small sack of olibanum.
 */
final class Olibanum extends AbstractLuxury
{
	private const VALUE = 4;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
