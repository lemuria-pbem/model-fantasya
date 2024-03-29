<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Repairable;

/**
 * A carriage wreck.
 */
final class CarriageWreck extends Carriage implements Repairable
{
	private const int WOOD = 1;

	public function Commodity(): Commodity {
		return self::createCommodity(Carriage::class);
	}

	protected function material(): array {
		return [self::class => 1, Wood::class => self::WOOD];
	}
}
