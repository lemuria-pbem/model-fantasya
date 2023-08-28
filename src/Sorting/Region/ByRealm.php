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
		$north2South = [];
		foreach ($this->getSortedLocations($set) as $row) {
			ksort($row);
			foreach ($row as $region) {
				/** @var Region $region */
				$north2South[$region->Continent()->Id()->Id()][] = $region->Id()->Id();
			}
		}
		$ids    = [];
		$realms = $this->getRealmRegions();
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
	protected function getRealmRegions(): array {
		$centers = [];
		foreach ($this->party->Possessions() as $realm) {
			$territory = $realm->Territory()->sort();
			$center    = $territory->Central();
			if ($center) {
				$regions = [];
				foreach ($territory as $region) {
					$regions[] = $region->Id()->Id();
				}
				$centers[$center->Id()->Id()] = $regions;
			}
		}
		return $centers;
	}
}
