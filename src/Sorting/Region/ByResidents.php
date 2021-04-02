<?php
declare (strict_types = 1);
namespace Lemuria\Sorting\Location;

use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unit;

/**
 * An ordering for regions by number of residents.
 */
class North2South implements EntityOrder
{
	/**
	 * Sort entities and return the entity IDs in sorted order.
	 *
	 * @return int[]
	 */
	public function sort(EntitySet $atlas): array {
		$residents = [];
		foreach ($atlas as $region /* @var Region $region */) {
			$n = 0;
			foreach ($region->Residents() as $unit /* @var Unit $unit */) {
				$n += $unit->Size();
			}
			$residents[$region->Id()->Id()] = $n;
		}
		asort($residents);
		return array_keys($residents);
	}
}
