<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

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

	protected function get(Id $id): Entity {
		return Vessel::get($id);
	}
}
