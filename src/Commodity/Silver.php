<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A silver coin.
 */
final class Silver implements Commodity
{
	private const WEIGHT = 1;

	use SingletonTrait;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
