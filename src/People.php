<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ExpectedValues;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Reorder;

/**
 * The people of a player or party is the community of all its units.
 */
class People extends EntitySet implements Reorder
{
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
	public function reorder(Unit $unit, Unit $position,
							#[ExpectedValues(valuesFromClass: Reorder::class)] int $order = Reorder::FLIP): People
	{
		$this->reorderEntity($unit->Id(), $position->Id(), $order);
		return $this;
	}

	/**
	 * Get a unit by ID.
	 */
	protected function get(Id $id): Entity {
		return Unit::get($id);
	}
}
