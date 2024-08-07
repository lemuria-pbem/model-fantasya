<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Sorting\Construction\ByBuilding;
use Lemuria\Sorting\ById;
use Lemuria\Sorting\ByName;
use Lemuria\SortMode;

/**
 * The estate in a region is the list of constructions that have been build there.
 *
 * @method Construction offsetGet(int|Id $offset)
 * @method Construction current()
 * @method Estate getIterator()
 */
class Estate extends EntitySet
{
	public function getClone(): static {
		return clone $this;
	}

	public function add(Construction $construction): static {
		$this->addEntity($construction->Id());
		if ($this->hasCollector()) {
			$construction->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Construction $construction): static {
		$this->removeEntity($construction->Id());
		return $this;
	}

	/**
	 * Sort the constructions.
	 */
	public function sort(SortMode $mode = SortMode::ByType): static {
		switch ($mode) {
			case SortMode::Alphabetically :
				$this->sortUsing(new ByName());
				break;
			case SortMode::ById :
				$this->sortUsing(new ById());
				break;
			case SortMode::ByType :
				$this->sortUsing(new ByBuilding());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	protected function get(Id $id): Construction {
		return Construction::get($id);
	}
}
