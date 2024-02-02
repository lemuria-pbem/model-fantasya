<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Location;
use Lemuria\Model\World\Strategy\ShortestPath;
use Lemuria\Model\World\Way;

trait RoadTrait
{
	protected function hasCompletedRoad(Way $way): bool {
		$way->rewind();
		if (!$way->valid()) {
			return true;
		}

		/** @var Region $from */
		$from = $way->current();
		$way->next();
		while ($way->valid()) {
			$direction = $way->key();
			if ($from->Roads()?->offsetGet($direction) < 1.0) {
				return false;
			}
			/** @var Region $to */
			$to        = $way->current();
			$direction = $direction->getOpposite();
			if ($to->Roads()?->offsetGet($direction) < 1.0) {
				return false;
			}
			$from = $to;
			$way->next();
		}

		return true;
	}

	protected function hasCompletedRoadBetween(Location $from, Location $to): bool {
		foreach (Lemuria::World()->findPath($from, $to, ShortestPath::class)->getAll() as $way) {
			if ($this->hasCompletedRoad($way)) {
				return true;
			}
		}
		return false;
	}
}
