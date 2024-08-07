<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Collector;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Identifiable;
use Lemuria\Lemuria;
use Lemuria\Model\Domain;
use Lemuria\Model\Reassignment;
use Lemuria\Sorting\ByName;
use Lemuria\SortMode;
use Lemuria\Sorting\ById;

/**
 * A Gathering is a set of parties.
 *
 * @method Party offsetGet(int|Id $offset)
 * @method Party current()
 * @method Gathering getIterator()
 * @method Party random()
 */
class Gathering extends EntitySet implements Reassignment
{
	private bool $isReassign = false;

	public function __construct(?Collector $collector = null) {
		parent::__construct($collector);
	}

	public function getClone(): static {
		return clone $this;
	}

	public function add(Party $party): static {
		$this->addEntity($party->Id());
		return $this;
	}

	public function reassign(Id $oldId, Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Party && $this->has($oldId)) {
			$this->replace($oldId, $identifiable->Id());
		}
	}

	public function remove(Identifiable $identifiable): void {
		if ($identifiable->Catalog() === Domain::Party && $this->has($identifiable->Id())) {
			$this->removeEntity($identifiable->Id());
		}
	}

	/**
	 * Sort the parties.
	 */
	public function sort(SortMode $mode = SortMode::ById): static {
		switch ($mode) {
			case SortMode::Alphabetically :
				$this->sortUsing(new ByName());
				break;
			case SortMode::ById :
				$this->sortUsing(new ById());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	public function addReassignment(): static {
		if (!$this->isReassign) {
			Lemuria::Catalog()->addReassignment($this);
			$this->isReassign = true;
		}
		return $this;
	}

	/**
	 * Get a party by ID.
	 */
	protected function get(Id $id): Party {
		return Party::get($id);
	}
}
