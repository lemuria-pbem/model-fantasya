<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Reorder;

/**
 * The people of a player or party is the community of all its units.
 */
class People extends EntitySet implements Reorder
{
	/**
	 * Add a unit to the people.
	 *
	 * @param Unit $unit
	 * @return People
	 */
	public function add(Unit $unit): People {
		parent::addEntity($unit->Id());
		if ($this->hasCollector()) {
			$unit->addCollector($this->collector());
		}
		return $this;
	}

	/**
	 * Remove a unit from the people.
	 *
	 * @param Unit $unit
	 * @return People
	 */
	public function remove(Unit $unit): People {
		parent::removeEntity($unit->Id());
		return $this;
	}

	/**
	 * Reorder a unit in the community.
	 *
	 * @param Unit $unit
	 * @param Unit $position
	 * @param int $order
	 * @return People
	 */
	public function reorder(Unit $unit, Unit $position, int $order = Reorder::FLIP): People {
		parent::reorderEntity($unit->Id(), $position->Id(), $order);
		return $this;
	}

	/**
	 * Get a unit by ID.
	 *
	 * @param Id $id
	 * @return Entity
	 */
	protected function get(Id $id): Entity {
		return Unit::get($id);
	}
}
