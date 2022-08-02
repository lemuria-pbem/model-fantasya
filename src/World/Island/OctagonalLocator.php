<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World\Island;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Coordinates;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\World\Island;
use Lemuria\Model\World\MapCoordinates;

class OctagonalLocator implements Locator
{
	public function findNeighbour(Region $region, Coordinates $coordinates, Island $island): ?Region {
		$neighbour = null;
		if ($island->isMapped($coordinates)) {
			// Region is within island area.
			if ($island->get($coordinates) === $region) {
				throw new LemuriaException('There is already a region at these coordinates.');
			}
			// Look for a neighbour.
			$neighbour = $island->get(new MapCoordinates($coordinates->X(), $coordinates->Y() + 1)); // north
			if (!$neighbour) {
				$neighbour = $island->get(new MapCoordinates($coordinates->X() + 1, $coordinates->Y())); // east
				if (!$neighbour) {
					$neighbour = $island->get(new MapCoordinates($coordinates->X(), $coordinates->Y() - 1)); // south
					if (!$neighbour) {
						$neighbour = $island->get(new MapCoordinates($coordinates->X() - 1, $coordinates->Y())); // west
					}
				}
			}
		} else {
			// Check if region is touching the island area.
			if ($coordinates->X() >= $island->Origin()->X() && $coordinates->X() < $island->Outer()->X()) {
				if ($coordinates->Y() === $island->Outer()->Y()) {
					// Check if region is touching northward.
					$neighbour = $island->get(new MapCoordinates($coordinates->X(), $island->Outer()->Y() - 1));
					if ($neighbour) {
						$island->extendNorth();
					}
				} elseif ($coordinates->Y() === $island->Origin()->Y() - 1) {
					// Check if region is touching southward.
					$neighbour = $island->get(new MapCoordinates($coordinates->X(), $island->Origin()->Y()));
					if ($neighbour) {
						$island->extendSouth();
					}
				}
			} elseif ($coordinates->Y() >= $island->Origin()->Y() && $coordinates->Y() < $island->Outer()->Y()) {
				if ($coordinates->X() === $island->Outer()->X()) {
					// Check if region is touching eastward.
					$neighbour = $island->get(new MapCoordinates($island->Outer()->X() - 1, $coordinates->Y()));
					if ($neighbour) {
						$island->extendEast();
					}
				} elseif ($coordinates->X() === $island->Origin()->X() - 1) {
					// Check if region is touching westward.
					$neighbour = $island->get(new MapCoordinates($island->Origin()->X(), $coordinates->Y()));
					if ($neighbour) {
						$island->extendWest();
					}
				}
			}
		}
		return $neighbour;
	}
}