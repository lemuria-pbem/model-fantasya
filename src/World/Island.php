<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Coordinates;
use Lemuria\Model\Fantasya\Landscape\Ocean;
use Lemuria\Model\Fantasya\Region;
use Lemuria\Model\Fantasya\World\Island\Locator;
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

	private Coordinates $outer;

	/**
	 * @var array[]
	 */
	private array $map;

	private int $width = 1;

	private int $height = 1;

	public function __construct(private Coordinates $origin, Region $region, private readonly Locator $locator) {
		$this->id  = new Id(self::$nextId++);
		$this->map = [[$region]];
		$this->updateOuter();
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

	public function Outer(): Coordinates {
		return $this->outer;
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
		if ($coordinates->X() >= $this->origin->X() && $coordinates->X() < $this->outer->X()) {
			if ($coordinates->Y() >= $this->origin->Y() && $coordinates->Y() < $this->outer->Y()) {
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

		if ($this->isMapped($coordinates)) {
			$existing = $this->get($coordinates);
			if ($existing === $region) {
				return $this; // Region already added.
			}
		}

		$neighbour = $this->locator->findNeighbour($region, $coordinates, $this);
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
		$this->height++;
		$this->updateOuter();
		return $this->height;
	}

	/**
	 * Extend eastward and return new width.
	 */
	public function extendEast(): int {
		for ($y = 0; $y < $this->height; $y++) {
			$this->map[$y][] = null;
		}
		$this->width++;
		$this->updateOuter();
		return $this->width;
	}

	/**
	 * Extend southward and return new height.
	 */
	public function extendSouth(): int {
		array_unshift($this->map, array_fill(0, $this->width, null));
		$this->origin = new MapCoordinates($this->origin->X(), $this->origin->Y() - 1);
		$this->height++;
		$this->updateOuter();
		return $this->height;
	}

	/**
	 * Extend westward and return new width.
	 */
	public function extendWest(): int {
		for ($y = 0; $y < $this->height; $y++) {
			array_unshift($this->map[$y], null);
		}
		$this->origin = new MapCoordinates($this->origin->X() - 1, $this->origin->Y());
		$this->width++;
		$this->updateOuter();
		return $this->width;
	}

	/**
	 * Check if another island has common coordinates.
	 */
	public function hasIntersection(Island $island): bool {
		return $this->locator->hasIntersection($this, $island);
	}

	/**
	 * Check if another island is a direct neighbour.
	 */
	public function hasNeighbour(Island $island): bool {
		return $this->locator->hasNeighbour($this, $island);
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
		$this->updateOuter();
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

	protected function updateOuter(): void {
		$this->outer = new MapCoordinates($this->outerX(), $this->outerY());
	}

	protected function outerX(): int {
		return $this->origin->X() + $this->width;
	}

	protected function outerY(): int {
		return $this->origin->Y() + $this->height;
	}
}
