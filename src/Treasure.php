<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The treasure of a unit is the collection of all unica it possesses.
 */
class Treasure extends EntitySet
{
	public function add(Unicum $unicum): Treasure {
		$this->addEntity($unicum->Id());
		if ($this->hasCollector()) {
			$unicum->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Unicum $unicum): Treasure {
		$this->removeEntity($unicum->Id());
		if ($this->hasCollector()) {
			$unicum->removeCollector($this->collector());
		}
		return $this;
	}

	/**
	 * Get an unicum by ID.
	 */
	protected function get(Id $id): Entity {
		return Unicum::get($id);
	}
}
