<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ExpectedValues;
use Lemuria\EntitySet;
use Lemuria\Exception\EntitySetException;
use Lemuria\Id;
use Lemuria\Reorder;

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
		/* @var Unit $owner */
		$owner = $this->owner ? $this->get($this->owner) : null;
		return $owner;
	}

	public function setOwner(Unit $unit): self {
		if (!$this->has($unit->Id())) {
			throw new EntitySetException($unit->Id());
		}

		$owner = $this->Owner();
		if ($unit !== $owner) {
			$this->reorderEntity($unit->Id(), $owner->Id(), -1);
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
	 * Reorder a unit in the inhabitants.
	 */
	public function reorder(Unit $unit, Unit $position,
							#[ExpectedValues(valuesFromClass: Reorder::class)] int $order = Reorder::FLIP): People
	{
		if ($unit !== $this->Owner()) {
			if ($position !== $this->Owner() || $order >= Reorder::AFTER) {
				$this->reorderEntity($unit->Id(), $position->Id(), $order);
			}
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
