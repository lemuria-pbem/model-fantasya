<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\World;

use Lemuria\Collector;
use Lemuria\EntityContainer;
use Lemuria\Model\Fantasya\Continent;
use Lemuria\Model\Fantasya\Sorting\Region\ByResidents;
use Lemuria\Model\Location;
use Lemuria\Model\World\Atlas;
use Lemuria\Model\World\SortMode;
use Lemuria\NullContainer;

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

	public function sort(SortMode $mode = SortMode::BY_ID): Atlas {
		switch ($mode) {
			case SortMode::BY_RESIDENTS :
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
