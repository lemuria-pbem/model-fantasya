<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\World;

use JetBrains\PhpStorm\ExpectedValues;

use JetBrains\PhpStorm\Immutable;

use Lemuria\Model\Coordinates;
use Lemuria\Model\Exception\MapException;
use Lemuria\Model\Lemuria\Party;
use Lemuria\Model\Location;
use Lemuria\Model\Neighbours;
use Lemuria\Model\World;
use Lemuria\Model\World\MapCoordinates;
use Lemuria\Serializable;

/**
 * This is a decorated world that calculates map coordinates for a specific party.
 */
#[Immutable]
final class PartyMap implements World
{
	public function __construct(private World $world, private Party $party) {
	}

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
	 * Get the neighbour regions of a region.
	 *
	 * @throws MapException
	 */
	public function getNeighbours(Location $location): Neighbours {
		return $this->world->getNeighbours($location);
	}

	/**
	 * Check if a direction is valid in this world.
	 */
	public function isDirection(#[ExpectedValues(valuesFromClass: self::class)] string $direction): bool {
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
