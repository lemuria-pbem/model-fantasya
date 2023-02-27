<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Sorting\Unit\ByParty;
use Lemuria\Model\Sized;
use Lemuria\Reorder;
use Lemuria\Sorting\ById;
use Lemuria\Sorting\BySize;
use Lemuria\SortMode;

/**
 * The people of a player or party is the community of all its units.
 *
 * @method Unit offsetGet(int|Id $offset)
 * @method Unit current()
 * @method People getIterator()
 * @method Unit random()
 */
class People extends EntitySet implements Sized
{
	/**
	 * Count the total size of all entities.
	 */
	public function Size(): int {
		$size = 0;
		foreach ($this as $unit /* @var Unit $unit */) {
			$size += $unit->Size();
		}
		return $size;
	}

	public function Weight(): int {
		$weight = 0;
		foreach ($this as $unit /* @var Unit $unit */) {
			$weight += $unit->Weight();
		}
		return $weight;
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
	public function reorder(Unit $unit, Unit $position, Reorder $order = Reorder::Flip): People
	{
		$this->reorderEntity($unit->Id(), $position->Id(), $order);
		return $this;
	}

	/**
	 * Sort the units.
	 */
	public function sort(SortMode $mode = SortMode::ById, ?Party $party = null): People {
		switch ($mode) {
			case SortMode::ById :
				$this->sortUsing(new ById());
				break;
			case SortMode::ByParty :
				$this->sortUsing(new ByParty($party));
				break;
			case SortMode::BySize :
				$this->sortUsing(new BySize());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	/**
	 * Get a unit by ID.
	 */
	protected function get(Id $id): Unit {
		return Unit::get($id);
	}
}
