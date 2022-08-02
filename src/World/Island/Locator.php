<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World\Island;

use Lemuria\Model\Coordinates;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\World\Island;

interface Locator
{
	public function findNeighbour(Region $region, Coordinates $coordinates, Island $island): ?Region;

	public function hasIntersection(Island $island, Island $other): bool;

	public function hasNeighbour(Island $island, Island $other): bool;
}
