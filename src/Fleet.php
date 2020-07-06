<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The fleet in a region is the list of vessels that have landed there.
 */
class Fleet extends EntitySet
{
	/**
	 * Add a vessel.
	 *
	 * @param Vessel $vessel
	 * @return Fleet
	 */
	public function add(Vessel $vessel): self {
		parent::addEntity($vessel->Id());
		if ($this->hasCollector()) {
			$vessel->addCollector($this->collector());
		}
		return $this;
	}

	/**
	 * Remove a vessel.
	 *
	 * @param Vessel $vessel
	 * @return Fleet
	 */
	public function remove(Vessel $vessel): self {
		parent::removeEntity($vessel->Id());
		return $this;
	}

	/**
	 * Get an Entity by ID.
	 *
	 * @param Id $id
	 * @return Entity
	 */
	protected function get(Id $id): Entity {
		return Vessel::get($id);
	}
}
