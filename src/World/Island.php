<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Coordinates;
use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\World\MapCoordinates;

/**
 * An island consists of neighbouring land regions and are surrounded by ocean or chaos.
 *
 * Regions that are direct north-south or east-west neighbours are on the same island. If they are just touching
 * diagonally (separated by a strait), they belong to separate islands.
 */
class Island
{
	private static int $nextId = 1;

	private readonly Id $id;

	private Coordinates $origin;

	/**
	 * @var array[]
	 */
	private array $map;

	private int $width = 1;

	private int $height = 1;

	public function __construct(Coordinates $coordinates, Region $region) {
		$this->id     = new Id(self::$nextId++);
		$this->origin = $coordinates;
		$this->map    = [[$region]];
	}

	public function Id(): Id {
		return $this->id;
	}

	public function Origin(): Coordinates {
		return $this->origin;
	}

	public function Width(): int {
		return $this->width;
	}

	public function Height(): int {
		return $this->height;
	}

	public function Size(): int {
		$size = 0;
		for ($y = 0; $y < $this->height; $y++) {
			for ($x = 0; $x < $this->width; $x++) {
				if ($this->map[$y][$x]) {
					$size++;
				}
			}
		}
		return $size;
	}

	public function isMapped(Coordinates $coordinates): bool {
		if ($coordinates->X() >= $this->origin->X() && $coordinates->X() < $this->outerX()) {
			if ($coordinates->Y() >= $this->origin->Y() && $coordinates->Y() < $this->outerY()) {
				return true;
			}
		}
		return false;
	}

	public function contains(Region $region): bool {
		for ($y = 0; $y < $this->height; $y++) {
			for ($x = 0; $x < $this->width; $x++) {
				if ($this->map[$y][$x] === $region) {
					return true;
				}
			}
		}
		return false;
	}

	public function get(Coordinates $coordinates): ?Region {
		if ($this->isMapped($coordinates)) {
			$x = $coordinates->X() - $this->origin->X();
			$y = $coordinates->Y() - $this->origin->Y();
			return $this->map[$y][$x];
		}
		return null;
	}

	public function add(Coordinates $coordinates, Region $region): Island {
		if ($region->Landscape() instanceof Ocean) {
			throw new LemuriaException('Oceans are not part of islands.');
		}

		$neighbour = null;
		if ($this->isMapped($coordinates)) {
			// Region is within island area.
			$existing = $this->get($coordinates);
			if ($existing === $region) {
				return $this; // Region already added.
			}
			if ($existing) {
				throw new LemuriaException('There is already a region at these coordinates.');
			}
			// Look for a neighbour.
			$neighbour = $this->get(new MapCoordinates($coordinates->X(), $coordinates->Y() + 1)); // north
			if (!$neighbour) {
				$neighbour = $this->get(new MapCoordinates($coordinates->X() + 1, $coordinates->Y())); // east
				if (!$neighbour) {
					$neighbour = $this->get(new MapCoordinates($coordinates->X(), $coordinates->Y() - 1)); // south
					if (!$neighbour) {
						$neighbour = $this->get(new MapCoordinates($coordinates->X() - 1, $coordinates->Y())); // west
					}
				}
			}
		} else {
			// Check if region is touching the island area.
			if ($coordinates->X() >= $this->origin->X() && $coordinates->X() < $this->outerX()) {
				if ($coordinates->Y() === $this->outerY()) {
					// Check if region is touching northward.
					$neighbour = $this->get(new MapCoordinates($coordinates->X(), $this->outerY() - 1));
					if ($neighbour) {
						$this->extendNorth();
					}
				} elseif ($coordinates->Y() === $this->origin->Y() - 1) {
					// Check if region is touching southward.
					$neighbour = $this->get(new MapCoordinates($coordinates->X(), $this->origin->Y()));
					if ($neighbour) {
						$this->extendSouth();
					}
				}
			} elseif ($coordinates->Y() >= $this->origin->Y() && $coordinates->Y() < $this->outerY()) {
				if ($coordinates->X() === $this->outerX()) {
					// Check if region is touching eastward.
					$neighbour = $this->get(new MapCoordinates($this->outerX() - 1, $coordinates->Y()));
					if ($neighbour) {
						$this->extendEast();
					}
				} elseif ($coordinates->X() === $this->origin->X() - 1) {
					// Check if region is touching westward.
					$neighbour = $this->get(new MapCoordinates($this->origin->X(), $coordinates->Y()));
					if ($neighbour) {
						$this->extendWest();
					}
				}
			}
		}
		if (!$neighbour) {
			throw new LemuriaException('There is no landmass next to the region.');
		}

		$x                 = $coordinates->X() - $this->origin->X();
		$y                 = $coordinates->Y() - $this->origin->Y();
		$this->map[$y][$x] = $region;
		return $this;
	}

	/**
	 * Extend northward and return new height.
	 */
	public function extendNorth(): int {
		$this->map[] = array_fill(0, $this->width, null);
		return ++$this->height;
	}

	/**
	 * Extend eastward and return new width.
	 */
	public function extendEast(): int {
		for ($y = 0; $y < $this->height; $y++) {
			$this->map[$y][] = null;
		}
		return ++$this->width;
	}

	/**
	 * Extend southward and return new height.
	 */
	public function extendSouth(): int {
		array_unshift($this->map, array_fill(0, $this->width, null));
		$this->origin = new MapCoordinates($this->origin->X(), $this->origin->Y() - 1);
		return ++$this->height;
	}

	/**
	 * Extend westward and return new width.
	 */
	public function extendWest(): int {
		for ($y = 0; $y < $this->height; $y++) {
			array_unshift($this->map[$y], null);
		}
		$this->origin = new MapCoordinates($this->origin->X() - 1, $this->origin->Y());
		return ++$this->width;
	}

	/**
	 * Check if another island has common coordinates.
	 */
	public function hasIntersection(Island $island): bool {
		$x1 = $this->origin->X();
		$y1 = $this->origin->Y();
		$w1 = $x1 + $this->width - 1;
		$h1 = $y1 + $this->height - 1;
		$x2 = $island->origin->X();
		$y2 = $island->origin->Y();
		$w2 = $x2 + $island->width - 1;
		$h2 = $y2 + $island->height - 1;

		if ($h2 >= $y1 && $h2 <= $h1) {
			if ($x2 >= $x1 && $x2 <= $w1) {
				return true; // Island's NW corner intersects.
			}
			if ($w2 >= $x1 && $w2 <= $w1) {
				return true; // Island's NE corner intersects.
			}
		} elseif ($y2 >= $y1 && $y2 <= $h1) {
			if ($x2 >= $x1 && $x2 <= $w1) {
				return true; // Island's SW corner intersects.
			}
			if ($w2 >= $x1 && $w2 <= $w1) {
				return true; // Island's SE corner intersects.
			}
		}
		return false;
	}

	/**
	 * Check if another island is a direct neighbour.
	 */
	public function hasNeighbour(Island $island): bool {
		$x1 = $this->origin->X();
		$y1 = $this->origin->Y();
		$w1 = $x1 + $this->width;
		$h1 = $y1 + $this->height;
		$x2 = $island->origin->X();
		$y2 = $island->origin->Y();
		$w2 = $x2 + $island->width;
		$h2 = $y2 + $island->height;

		if ($x1 < $w2 && $x2 < $w1) {
			if ($y2 === $h1) {
				return true; // Island is touching north.
			}
			if ($y1 === $h2) {
				return true; // Island is touching south.
			}
		} elseif ($y1 < $h2 && $y2 < $h1) {
			if ($x2 === $w1) {
				return true; // Island is touching east.
			}
			if ($x1 === $w2) {
				return true; // Island is touching west.
			}
		}
		return false;
	}

	/**
	 * Merge another island.
	 *
	 * @throws LemuriaException
	 */
	public function merge(Island $island): Island {
		$regions = [];
		$w       = $island->Origin()->X() + $island->Width();
		$h       = $island->Origin()->Y() + $island->Height();
		for ($y = $island->Origin()->Y(); $y < $h; $y++) {
			for ($x = $island->Origin()->X(); $x < $w; $x++) {
				$coordinates = new MapCoordinates($x, $y);
				$region      = $island->get($coordinates);
				if ($region) {
					$regions[] = [$coordinates, $region];
				}
			}
		}

		$merged = clone $this;
		do {
			$count = count($regions);
			foreach (array_keys($regions) as $i) {
				$coordinates = $regions[$i][0];
				$region      = $regions[$i][1];
				try {
					$merged->add($coordinates, $region);
					unset ($regions[$i]);
				} catch (LemuriaException) {
				}
			}
		} while ($count > 0 && count($regions) < $count);

		if ($count > 0) {
			throw new LemuriaException('Island cannot be merged completely.');
		}
		$this->origin = $merged->origin;
		$this->width  = $merged->width;
		$this->height = $merged->height;
		$this->map    = $merged->map;
		return $this;
	}

	public function getRegions(): array {
		$regions = [];
		for ($y = 0; $y < $this->height; $y++) {
			for ($x = 0; $x < $this->width; $x++) {
				$region = $this->map[$y][$x];
				if ($region) {
					$regions[] = $region;
				}
			}
		}
		return $regions;
	}

	protected function outerX(): int {
		return $this->origin->X() + $this->width;
	}

	protected function outerY(): int {
		return $this->origin->Y() + $this->height;
	}
}
