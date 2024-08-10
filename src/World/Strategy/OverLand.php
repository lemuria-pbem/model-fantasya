<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World\Strategy;

use Lemuria\Model\Fantasya\Navigable;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Location;
use Lemuria\Model\World\Direction;
use Lemuria\Model\World\Strategy\ShortestPath;

class OverLand extends ShortestPath
{
	protected function isValidNeighbour(Direction $direction, Location $neighbour): bool {
		if ($neighbour instanceof Region && $neighbour->Landscape() instanceof Navigable) {
			return false;
		}
		return parent::isValidNeighbour($direction, $neighbour);
	}
}
