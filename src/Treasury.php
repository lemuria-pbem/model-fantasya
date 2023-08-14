<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The treasury of a unit is the collection of all unica it possesses.
 *
 * @method Unicum offsetGet(int|Id $offset)
 * @method Unicum current()
 */
class Treasury extends EntitySet
{
	public function getClone(): static {
		return clone $this;
	}

	public function add(Unicum $unicum): static {
		$this->addEntity($unicum->Id());
		if ($this->hasCollector()) {
			$unicum->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Unicum $unicum): static {
		$this->removeEntity($unicum->Id());
		if ($this->hasCollector()) {
			$unicum->removeCollector($this->collector());
		}
		return $this;
	}

	/**
	 * Get an unicum by ID.
	 */
	protected function get(Id $id): Unicum {
		return Unicum::get($id);
	}
}
