<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\World\SortMode;
use Lemuria\Sorting\ById;

/**
 * A Gathering is a set of parties.
 *
 * @\ArrayAccess<int|Id, Party>
 * @\Iterator<int, Party>
 */
class Gathering extends EntitySet
{
	public function add(Party $party): Gathering {
		$this->addEntity($party->Id());
		return $this;
	}

	public function remove(Party $party): Gathering {
		$this->removeEntity($party->Id());
		return $this;
	}

	/**
	 * Sort the parties.
	 */
	public function sort(SortMode $mode = SortMode::BY_ID): Gathering {
		switch ($mode) {
			case SortMode::BY_ID :
				$this->sortUsing(new ById());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	/**
	 * Get a party by ID.
	 */
	protected function get(Id $id): Entity {
		return Party::get($id);
	}
}
