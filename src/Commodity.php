<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Singleton;

/**
 * A commodity is everything that a unit can carry.
 */
interface Commodity extends Singleton
{
	/**
	 * Get the weight of a product.
	 */
	#[Pure] public function Weight(): int;
}
