<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Luxury;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\CommodityTrait;
use Lemuria\Model\Fantasya\Luxury;
use Lemuria\SingletonSet;
use Lemuria\SingletonTrait;

/**
 * Base class for any luxury.
 */
abstract class AbstractLuxury implements Luxury
{
	use CommodityTrait;
	use SingletonTrait;

	private const WEIGHT = 1 * 100;

	public static function all(): SingletonSet {
		return self::getAll(__DIR__);
	}

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}
}
