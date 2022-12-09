<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Collector;
use Lemuria\EntityContainer;
use Lemuria\Model\Fantasya\Continent;
use Lemuria\Model\Fantasya\Sorting\Region\ByResidents;
use Lemuria\Model\Location;
use Lemuria\Model\World\Atlas;
use Lemuria\NullContainer;
use Lemuria\SortMode;

class FantasyaAtlas extends Atlas
{
	private EntityContainer $landmass;

	public function __construct(readonly ?Collector $collector = null) {
		parent::__construct($collector);
		$this->landmass = new NullContainer();
	}

	public function add(Location $location): Atlas {
		if ($this->landmass->contains($location)) {
			return parent::add($location);
		}
		return $this;
	}

	public function sort(SortMode $mode = SortMode::ById): Atlas {
		switch ($mode) {
			case SortMode::ByResidents :
				$this->sortUsing(new ByResidents());
				break;
			default :
				return parent::sort($mode);
		}
		return $this;
	}

	public function forContinent(Continent $continent): FantasyaAtlas {
		$this->landmass = $continent->Landmass();
		return $this;
	}
}
