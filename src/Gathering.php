<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Entity;
use Lemuria\EntitySet;
use Lemuria\Id;

/**
 * The people of a player or party is the community of all its units.
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
	 * Get a party by ID.
	 */
	protected function get(Id $id): Entity {
		return Party::get($id);
	}
}
