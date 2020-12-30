<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\SingletonTrait;

/**
 * A food ration for one person and round.
 */
final class Food implements Commodity
{
	public const PRICE = 10;

	private const WEIGHT = 10;

	use SingletonTrait;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Price(): int {
		return self::PRICE;
	}
}
