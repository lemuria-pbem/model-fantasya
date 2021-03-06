<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

/**
 * Luxuries are special commodities that are produced by peasants only.
 */
interface Luxury extends Commodity
{
	/**
	 * Get the value of one item.
	 */
	#[Pure] public function Value(): int;
}
