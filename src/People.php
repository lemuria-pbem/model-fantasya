<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Sorting\Unit\ByParty;
use Lemuria\Model\World\SortMode;
use Lemuria\Reorder;
use Lemuria\Sorting\ById;

/**
 * The people of a player or party is the community of all its units.
 */
class People extends EntitySet
{
	/**
	 * Count the total size of all entities.
	 */
	#[Pure] public function Size(): int {
		$size = 0;
		foreach ($this as $unit /* @var Unit $unit */) {
			$size += $unit->Size();
		}
		return $size;
	}

	/**
	 * Get the first unit.
	 */
	public function getFirst(): ?Unit {
		$id = $this->first();
		return $id ? Unit::get($id) : null;
	}

	/**
	 * Get the last unit.
	 */
	public function getLast(): ?Unit {
		$id = $this->last();
		return $id ? Unit::get($id) : null;
	}

	public function add(Unit $unit): People {
		$this->addEntity($unit->Id());
		if ($this->hasCollector()) {
			$unit->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Unit $unit): People {
		$this->removeEntity($unit->Id());
		if ($this->hasCollector()) {
			$unit->removeCollector($this->collector());
		}
		return $this;
	}

	/**
	 * Reorder a unit in the community.
	 */
	public function reorder(Unit $unit, Unit $position, Reorder $order = Reorder::FLIP): People
	{
		$this->reorderEntity($unit->Id(), $position->Id(), $order);
		return $this;
	}

	/**
	 * Sort the units.
	 */
	public function sort(SortMode $mode = SortMode::BY_ID, ?Party $party = null): People {
		switch ($mode) {
			case SortMode::BY_ID :
				$this->sortUsing(new ById());
				break;
			case SortMode::BY_PARTY :
				$this->sortUsing(new ByParty($party));
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	/**
	 * Get a unit by ID.
	 */
	protected function get(Id $id): Entity {
		return Unit::get($id);
	}
}
