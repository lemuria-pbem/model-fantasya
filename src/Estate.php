<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Sorting\Construction\ByBuilding;
use Lemuria\Sorting\ById;
use Lemuria\SortMode;

/**
 * The estate in a region is the list of constructions that have been build there.
 *
 * @\ArrayAccess<int|Id, Construction>
 * @\Iterator<int, Construction>
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

	/**
	 * Sort the constructions.
	 */
	public function sort(SortMode $mode = SortMode::BY_TYPE): Estate {
		switch ($mode) {
			case SortMode::BY_ID :
				$this->sortUsing(new ById());
				break;
			case SortMode::BY_TYPE :
				$this->sortUsing(new ByBuilding());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	protected function get(Id $id): Entity {
		return Construction::get($id);
	}
}
