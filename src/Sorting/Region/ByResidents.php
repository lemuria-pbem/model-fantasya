<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Region;

use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unit;

/**
 * An ordering for regions by number of residents.
 */
class ByResidents implements EntityOrder
{
	/**
	 * Sort entities and return the entity IDs in sorted order.
	 *
	 * @return array<int>
	 */
	public function sort(EntitySet $set): array {
		$residents = [];
		foreach ($set as $region /* @var Region $region */) {
			$n = 0;
			foreach ($region->Residents() as $unit /* @var Unit $unit */) {
				$n += $unit->Size();
			}
			$residents[$region->Id()->Id()] = $n;
		}
		asort($residents, SORT_NUMERIC);
		return array_keys($residents);
	}
}
