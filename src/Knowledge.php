<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;

/**
 * The knowledge that a unit has represents all talents that it is able to use.
 */
class Knowledge extends ItemSet
{
	use BuilderTrait;

	/**
	 * Add an ability.
	 *
	 * @param Ability $ability
	 * @return Knowledge
	 */
	public function add(Ability $ability): Knowledge {
		$this->addItem($ability);
		return $this;
	}

	/**
	 * Remove an ability.
	 *
	 * @param Ability $ability
	 * @return Knowledge
	 */
	public function remove(Ability $ability): Knowledge {
		$this->removeItem($ability);
		return $this;
	}

	/**
	 * Create an Item from unserialized data.
	 *
	 * @param string $class
	 * @param int $count
	 * @return Item
	 */
	protected function createItem(string $class, int $count): Item {
		return new Ability(self::createTalent($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 *
	 * @param Item $item
	 * @return bool
	 */
	protected function isValidItem($item): bool {
		return $item instanceof Ability;
	}
}
