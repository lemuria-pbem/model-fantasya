<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Sorting\Vessel\ByShip;
use Lemuria\Model\World\SortMode;
use Lemuria\Sorting\ById;

/**
 * The fleet in a region is the list of vessels that have landed there.
 *
 * @\ArrayAccess<int|Id, Vessel>
 * @\Iterator<int, Vessel>
 */
class Fleet extends EntitySet
{
	public function add(Vessel $vessel): self {
		$this->addEntity($vessel->Id());
		if ($this->hasCollector()) {
			$vessel->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Vessel $vessel): self {
		$this->removeEntity($vessel->Id());
		return $this;
	}

	/**
	 * Sort the constructions.
	 */
	public function sort(SortMode $mode = SortMode::BY_TYPE): Fleet {
		switch ($mode) {
			case SortMode::BY_ID :
				$this->sortUsing(new ById());
				break;
			case SortMode::BY_TYPE :
				$this->sortUsing(new ByShip());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	protected function get(Id $id): Entity {
		return Vessel::get($id);
	}
}
