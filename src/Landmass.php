<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The estate in a region is the list of constructions that have been build there.
 */
class Landmass extends EntitySet
{
	public function add(Region $region): self {
		$this->addEntity($region->Id());
		if ($this->hasCollector()) {
			$region->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Region $region): self {
		$this->removeEntity($region->Id());
		return $this;
	}

	protected function get(Id $id): Entity {
		return Region::get($id);
	}
}
