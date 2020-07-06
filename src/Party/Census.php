<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Party;

use Lemuria\Model\Lemuria\Exception\CensusException;
use Lemuria\Model\Lemuria\Party;
use Lemuria\Model\Lemuria\People;
use Lemuria\Model\Lemuria\Region;
use Lemuria\Model\Lemuria\Unit;
use Lemuria\Model\World\Atlas;

/**
 * The census is an analysis of a parties' regions and the units in its regions.
 */
class Census
{
	private Party $party;

	private Atlas $atlas;

	/**
	 * @var array(int=>People)
	 */
	private array $units = [];

	/**
	 * Create a Census for a Party.
	 *
	 * @param Party $party
	 */
	public function __construct(Party $party) {
		$this->atlas = new Atlas();
		foreach ($party->People() as $unit/* @var Unit $unit */) {
			$region = $unit->Region();
			$this->atlas->add($region);
			$id = $region->Id()->Id();
			if (!isset($this->units[$id])) {
				$this->units[$id] = new People();
			}
			$this->getPeople($region)->add($unit);
		}
		$this->atlas->sort(Atlas::NORTH_TO_SOUTH);
	}

	/**
	 * Get the Atlas of all regions known to the Party.
	 *
	 * @return Atlas
	 */
	public function getAtlas(): Atlas {
		return $this->atlas;
	}

	/**
	 * Get the units of a region.
	 *
	 * @param Region $region
	 * @return People
	 */
	public function getPeople(Region $region): People {
		$id = $region->Id()->Id();
		if (!isset($this->units[$id])) {
			throw new CensusException($region, $this->party);
		}
		return $this->units[$id];
	}
}
