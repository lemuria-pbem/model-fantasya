<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\EntitySet;
use Lemuria\Exception\EntitySetException;
use Lemuria\Exception\EntitySetReplaceException;
use Lemuria\Id;
use Lemuria\Reorder;
use Lemuria\SortMode;

/**
 * Among the inhabitants of a Construction or Vessel is one of them who is in command.
 */
class Inhabitants extends People
{
	private ?Id $owner = null;

	public function Owner(): ?Unit {
		if (!$this->owner) {
			$this->owner = $this->first();
		}
		/** @var Unit $owner */
		$owner = $this->owner ? $this->get($this->owner) : null;
		return $owner;
	}

	public function setOwner(Unit $unit): self {
		if (!$this->has($unit->Id())) {
			throw new EntitySetException($unit->Id());
		}

		$owner = $this->Owner();
		if ($unit !== $owner) {
			$this->reorderEntity($unit->Id(), $owner->Id(), Reorder::BEFORE);
			$this->owner = null;
		}
		return $this;
	}

	/**
	 * Clear the inhabitants.
	 */
	public function clear(): EntitySet {
		parent::clear();
		$this->owner = null;
		return $this;
	}

	/**
	 * Replace an entity in the set with another one that is not part of the set.
	 *
	 * @throws EntitySetException The entity is not part of the set.
	 * @throws EntitySetReplaceException The replacement is part of the set.
	 */
	public function replace(Id $search, Id $replace): void {
		parent::replace($search, $replace);
		$this->owner = null;
	}

	/**
	 * Reorder a unit in the inhabitants.
	 */
	public function reorder(Unit $unit, Unit $position, Reorder $order = Reorder::FLIP): People
	{
		if ($unit !== $this->Owner()) {
			if ($position !== $this->Owner() || $order >= Reorder::AFTER) {
				$this->reorderEntity($unit->Id(), $position->Id(), $order);
			}
		}
		return $this;
	}

	public function sort(SortMode $mode = SortMode::BY_ID, ?Party $party = null): People {
		$owner = $this->Owner();
		parent::sort($mode, $party);
		if ($owner) {
			$this->owner = $this->first();
			$this->setOwner($owner);
		}
		return $this;
	}

	/**
	 * Remove an entity's ID from the set.
	 *
	 * @throws EntitySetException The entity is not part of the set.
	 */
	protected function removeEntity(Id $id): void {
		parent::removeEntity($id);
		if ($this->count() <= 0 || $this->owner && $this->owner->Id() === $id->Id()) {
			$this->owner = null;
		}
	}
}
