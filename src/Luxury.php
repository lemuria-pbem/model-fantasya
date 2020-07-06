<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * Luxuries are special commodities that are produced by peasants only.
 */
interface Luxury extends Commodity
{
	/**
	 * Get the value of one item.
	 *
	 * @return int
	 */
	public function Value(): int;
}
