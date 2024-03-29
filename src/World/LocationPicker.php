<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use function Lemuria\getClass;
use Lemuria\Exception\LemuriaException;
use Lemuria\Lemuria;
use Lemuria\Model\Fantasya\Landscape;
use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Region;

/**
 * The LocationPicker is a helper class to find the best fitting locations.
 */
class LocationPicker implements \ArrayAccess, \Countable
{
	/**
	 * @var array<Region>
	 */
	private array $locations;

	/**
	 * @var array<string, array>
	 */
	private array $landscapes;

	/**
	 * Initialize the picker with all locations.
	 */
	public function __construct() {
		$this->reset();
	}

	public function Atlas(): FantasyaAtlas {
		$atlas = new FantasyaAtlas();
		foreach ($this->locations as $region) {
			$atlas->add($region);
		}
		return $atlas;
	}

	public function offsetExists($offset): bool {
		return isset($this->locations[$offset]);
	}

	public function offsetGet($offset): Region {
		return $this->locations[$offset];
	}

	public function offsetSet($offset, $value): void {
		throw new LemuriaException();
	}

	public function offsetUnset($offset): void {
		throw new LemuriaException();
	}

	public function count(): int {
		return count($this->locations);
	}

	public function random(): Region {
		return $this->locations[array_rand($this->locations)];
	}

	/**
	 * Filter for regions of a specific landscape.
	 */
	public function landscape(Landscape|string $landscape): static {
		$locations = [];
		$filter    = getClass($landscape);
		foreach ($this->landscapes as $type => $indices) {
			if ($type === $filter) {
				foreach ($indices as $i) {
					$locations[] = $this->locations[$i];
				}
				$this->locations         = $locations;
				$this->landscapes[$type] = array_keys($locations);
			} else {
				$this->landscapes[$type] = [];
			}
		}
		return $this;
	}

	/**
	 * Filter for regions that are land next to an ocean.
	 */
	public function coastal(): static {
		$locations                                = [];
		$this->landscapes[getClass(Ocean::class)] = [];
		$world                                    = Lemuria::World();
		$i                                        = 0;
		foreach ($this->landscapes as $type => $indices) {
			$landscape = [];
			foreach ($indices as $index) {
				$region = $this->locations[$index];
				foreach ($world->getNeighbours($region) as $neighbour /* @var Region $neighbour */) {
					if ($neighbour->Landscape() instanceof Ocean) {
						$locations[] = $region;
						$landscape[] = $i++;
						break;
					}
				}
			}
			$this->landscapes[$type] = $landscape;
		}
		$this->locations = $locations;
		return $this;
	}

	/**
	 * Filter for regions that have no residents.
	 */
	public function void(): static {
		$locations = [];
		$i         = 0;
		foreach ($this->landscapes as $type => $indices) {
			$landscape = [];
			foreach ($indices as $index) {
				$region = $this->locations[$index];
				if ($region->Residents()->count() <= 0) {
					$locations[] = $region;
					$landscape[] = $i++;
				}
			}
			$this->landscapes[$type] = $landscape;
		}
		$this->locations = $locations;
		return $this;
	}

	public function reset(): static {
		$this->locations  = [];
		$this->landscapes = [];
		$i = 0;
		foreach (Region::all() as $region) {
			$this->locations[]              = $region;
			$landscape                      = getClass($region->Landscape());
			$this->landscapes[$landscape][] = $i++;
		}
		return $this;
	}
}
