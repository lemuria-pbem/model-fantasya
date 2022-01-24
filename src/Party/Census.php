<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Party;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Exception\CensusException;
use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\People;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\Unit;
use Lemuria\Model\World\Atlas;
use Lemuria\Model\World\SortMode;

/**
 * The census is an analysis of a parties' regions and the units in its regions.
 */
class Census implements \Countable
{
	private readonly Atlas $atlas;

	/**
	 * @var array(int=>People)
	 */
	private array $units = [];

	/**
	 * Create a Census for a Party.
	 */
	public function __construct(private Party $party) {
		$this->atlas = new Atlas();
		foreach ($party->People() as $unit /* @var Unit $unit */) {
			$region = $unit->Region();
			$this->atlas->add($region);
			$id = $region->Id()->Id();
			if (!isset($this->units[$id])) {
				$this->units[$id] = new People();
			}
			$this->getPeople($region)->add($unit);
		}
		$this->atlas->sort(SortMode::NORTH_TO_SOUTH);
	}

	public function Party(): Party {
		return $this->party;
	}

	/**
	 * Get the number of all persons belonging to the party.
	 */
	#[Pure] public function count(): int {
		$n = 0;
		foreach ($this->party->People() as $unit /* @var Unit $unit */) {
			$n += $unit->Size();
		}
		return $n;
	}

	/**
	 * Get the Atlas of all regions known to the Party.
	 */
	#[Pure] public function getAtlas(): Atlas {
		return $this->atlas;
	}

	/**
	 * Get the units of a region.
	 */
	public function getPeople(Region $region): People {
		$id = $region->Id()->Id();
		if (!isset($this->units[$id])) {
			throw new CensusException($region, $this->party);
		}
		return $this->units[$id];
	}
}
