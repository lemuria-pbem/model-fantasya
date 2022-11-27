<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Sorting\Trade;

use function Lemuria\getClass;
use Lemuria\EntityOrder;
use Lemuria\EntitySet;
use Lemuria\Model\Fantasya\Market\Trade;

/**
 * An ordering for estate by their building type and size.
 */
class ByDeal implements EntityOrder
{
	/**
	 * @return int[]
	 */
	public function sort(EntitySet $set): array {
		$offers  = [];
		$demands = [];

		foreach ($set as $trade /* @var Trade $trade */) {
			$commodity = getClass($trade->Goods()->Commodity());
			$amount    = $trade->Goods()->Maximum();
			if ($trade->Trade() === Trade::OFFER) {
				$offers[$commodity][$amount][] = $trade->Id()->Id();
			} else {
				$demands[$commodity][$amount][] = $trade->Id()->Id();
			}
		}

		$sorted = [];
		ksort($offers);
		ksort($demands);
		foreach ($offers as $trades) {
			ksort($trades);
			foreach ($trades as $ids) {
				array_push($sorted, ...$ids);
			}
		}
		foreach ($demands as $trades) {
			ksort($trades);
			foreach ($trades as $ids) {
				array_push($sorted, ...$ids);
			}
		}
		return $sorted;
	}
}
