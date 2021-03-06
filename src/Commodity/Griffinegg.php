<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\SingletonTrait;

/**
 * A griffin egg.
 */
final class Griffinegg implements Commodity
{
	private const WEIGHT = 20 * 100;

	use SingletonTrait;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
