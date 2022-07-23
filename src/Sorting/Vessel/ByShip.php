<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Vessel;

use function Lemuria\getClass;
use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Ship\Boat;
use Lemuria\Model\Fantasya\Ship\Caravel;
use Lemuria\Model\Fantasya\Ship\Dragonship;
use Lemuria\Model\Fantasya\Ship\Galleon;
use Lemuria\Model\Fantasya\Ship\Longboat;
use Lemuria\Model\Fantasya\Ship\Trireme;
use Lemuria\Model\Fantasya\Vessel;

/**
 * An ordering for fleets by their ship type and size.
 */
class ByShip implements EntityOrder
{
	protected const ORDER = [
		Galleon::class, Trireme::class, Caravel::class, Dragonship::class, Longboat::class, Boat::class
	];

	/**
	 * @return int[]
	 */
	public function sort(EntitySet $set): array {
		$ships = [];
		foreach ($set as $vessel /* @var Vessel $vessel */) {
			$ship = getClass($vessel->Ship());
			if (!isset($ships[$ship])) {
				$ships[$ship] = [];
			}
			$ships[$ship][] = $vessel->Id()->Id();
		}

		$sorted = [];
		foreach (self::ORDER as $class) {
			$ship = getClass($class);
			if (isset($ships[$ship])) {
				$ids = $ships[$ship];
				sort($ids);
				foreach ($ids as $id) {
					$sorted[] = $id;
				}
			}
		}
		return $sorted;
	}
}
