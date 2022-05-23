<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Commodity\Carriage;
use Lemuria\Model\Fantasya\Commodity\CarriageWreck;
use Lemuria\Model\Fantasya\Commodity\Gold;
use Lemuria\Model\Fantasya\Commodity\Griffinegg;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Singleton;

/**
 * A commodity is everything that a unit can carry.
 */
interface Commodity extends Singleton
{
	public final const MISC = [
		Silver::class, Wood::class, Stone::class, Iron::class, Gold::class,
		...Transport::ANIMALS, Carriage::class, CarriageWreck::class,
		Griffinegg::class
	];

	/**
	 * Get the weight of a product.
	 */
	public function Weight(): int;
}
