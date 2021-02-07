<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The estate in a region is the list of constructions that have been build there.
 */
class Estate extends EntitySet
{
	public function add(Construction $construction): self {
		$this->addEntity($construction->Id());
		if ($this->hasCollector()) {
			$construction->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Construction $construction): self {
		$this->removeEntity($construction->Id());
		return $this;
	}

	protected function get(Id $id): Entity {
		return Construction::get($id);
	}
}
