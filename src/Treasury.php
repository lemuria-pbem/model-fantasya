<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Extension\Valuables;

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
		$id = $unicum->Id();
		$this->removeEntity($id);
		if ($this->hasCollector()) {
			$collector = $this->collector();
			if ($collector instanceof Unit) {
				$extensions = $collector->Extensions();
				if ($extensions->offsetExists(Valuables::class)) {
					/** @var Valuables $valuables */
					$valuables = $extensions->offsetGet(Valuables::class);
					if ($valuables->has($id)) {
						$valuables->remove($unicum);
					}
				}
			}
			$unicum->removeCollector($collector);
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
