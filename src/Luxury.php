<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * Luxuries are special commodities that are produced by peasants only.
 */
interface Luxury extends Commodity
{
	/**
	 * Get the value of one item.
	 */
	public function Value(): int;
}
