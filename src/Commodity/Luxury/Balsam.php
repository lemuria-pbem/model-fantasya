<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

/**
 * A small barrel of balsam.
 */
final class Balsam extends AbstractLuxury
{
	private const VALUE = 4;

	#[Pure] public function Value(): int {
		return self::VALUE;
	}
}
