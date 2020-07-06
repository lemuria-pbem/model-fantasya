<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Singleton;

/**
 * A commodity is everything that a unit can carry.
 */
interface Commodity extends Singleton
{
	/**
	 * Get the weight of a product.
	 *
	 * @return int
	 */
	public function Weight(): int;
}
