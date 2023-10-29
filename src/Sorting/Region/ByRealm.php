<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Region;

use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\World\Atlas;
use Lemuria\Sorting\Location\North2South;

/**
 * An ordering for locations using sorting by coordinates and clustered by
 * realm.
 */
class ByRealm extends North2South
{
	public function __construct(protected readonly Party $party) {
	}

	/**
	 * Sort entities and return the entity IDs in sorted order.
	 *
	 * @param Atlas $set
	 * @return array<int>
	 */
	public function sort(EntitySet $set): array {
		$allRegions  = [];
		$north2South = [];
		foreach ($this->getSortedLocations($set) as $row) {
			ksort($row);
			foreach ($row as $region) {
				/** @var Region $region */
				$id                                              = $region->Id()->Id();
				$allRegions[$id]                                 = true;
				$north2South[$region->Continent()->Id()->Id()][] = $id;
			}
		}
		$ids    = [];
		$realms = $this->getRealmRegions($allRegions);
		foreach ($realms as $regions) {
			foreach ($regions as $id) {
				$ids[$id] = true;
			}
		}

		$sorted = [];
		foreach ($north2South as $continent => $locations) {
			foreach ($locations as $id) {
				if (!isset($ids[$id])) {
					$sorted[$continent][] = $id;
				} elseif (isset($realms[$id])) {
					if (isset($sorted[$continent])) {
						$sorted[$continent] = array_merge($sorted[$continent], $realms[$id]);
					} else {
						$sorted[$continent] = $realms[$id];
					}
				}
			}
		}
		return array_merge(...$sorted);
	}

	/**
	 * @return array<int, array<int>>
	 */
	protected function getRealmRegions(array $allRegions): array {
		$centers = [];
		foreach ($this->party->Possessions() as $realm) {
			$territory = $realm->Territory()->sort();
			$center    = $territory->Central();
			if ($center) {
				$regions = [];
				foreach ($territory as $region) {
					$id = $region->Id()->Id();
					if (isset($allRegions[$id])) {
						$regions[] = $id;
					}
				}
				if (!empty($regions)) {
					$centers[$center->Id()->Id()] = $regions;
				}
			}
		}
		return $centers;
	}
}
