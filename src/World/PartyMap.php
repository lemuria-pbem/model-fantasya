<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Immutable;

use Lemuria\Model\Coordinates;
use Lemuria\Model\Exception\MapException;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Location;
use Lemuria\Model\Neighbours;
use Lemuria\Model\World;
use Lemuria\Model\World\MapCoordinates;
use Lemuria\Model\World\Path;
use Lemuria\Serializable;

/**
 * This is a decorated world that calculates map coordinates for a specific party.
 */
#[Immutable]
final class PartyMap implements World
{
	public function __construct(private readonly World $world, private readonly Party $party) {
	}

	#[ArrayShape(['id' => "int", 'name' => "string", 'description' => "string", 'inhabitants' => "int[]",
				  'size' => "int", 'building' => "string"])]
	public function serialize(): array {
		return $this->world->serialize();
	}

	/**
	 * Not implemented.
	 */
	public function unserialize(array $data): Serializable {
		return $this;
	}

	/**
	 * Get the world coordinates of a region, based on the party's origin.
	 *
	 * @throws MapException
	 */
	public function getCoordinates(Location $location): Coordinates {
		$coordinates = $this->world->getCoordinates($location);
		$origin      = $this->world->getCoordinates($this->party->Origin());

		$x = $coordinates->X() - $origin->X();
		$y = $coordinates->Y() - $origin->Y();
		return new MapCoordinates($x, $y);
	}

	/**
	 * Get the shortest distance between two regions.
	 *
	 * @throws MapException
	 */
	public function getDistance(Location $from, Location $to): int {
		return $this->world->getDistance($from, $to);
	}

	/**
	 * Get the neighbour regions of a region.
	 *
	 * @throws MapException
	 */
	public function getNeighbours(Location $location): Neighbours {
		return $this->world->getNeighbours($location);
	}

	/**
	 * Get the path from a location to a distant point.
	 */
	public function getPath(Location $start, World\Direction $direction, int $distance): Path {
		return $this->world->getPath($start, $direction, $distance);
	}

	/**
	 * Check if a direction is valid in this world.
	 */
	public function isDirection(World\Direction $direction): bool {
		return $this->world->isDirection($direction);
	}

	/**
	 * Not implemented.
	 */
	public function load(): World {
		return $this;
	}

	/**
	 * Not implemented.
	 */
	public function save(): World {
		return $this;
	}
}
