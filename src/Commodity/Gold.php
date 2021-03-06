<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\SingletonTrait;

/**
 * A gold nugget.
 */
final class Gold implements Commodity
{
	private const WEIGHT = 5 * 100;

	use SingletonTrait;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
