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
	use SingletonTrait;

	private const WEIGHT = 20 * 100;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
