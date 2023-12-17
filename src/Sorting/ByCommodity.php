<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting;

use Lemuria\ItemOrder;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Resources;

class ByCommodity implements ItemOrder
{
	/**
	 * Sort items and return the singletons in sorted order.
	 *
	 * @param Resources $set
	 * @return array<string>
	 */
	public function sort(ItemSet $set): array {
		$commodities = [];
		foreach ($set as $quantity) {
			$commodities[(string)$quantity->Commodity()] = true;
		}
		$allCommodities = Resources::getAll();
		$sortOrder      = array_fill_keys($allCommodities, null);
		foreach ($allCommodities as $commodity) {
			if (!isset($commodities[$commodity])) {
				unset($sortOrder[$commodity]);
			}
		}
		return array_keys($sortOrder);
	}
}
