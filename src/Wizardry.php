<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;

/**
 * The wizardry is a set of enchantments.
 *
 * @\ArrayAccess <Spell|string, Enchantment>
 * @\Iterator <string, Enchantment>
 */
class Wizardry extends ItemSet
{
	use BuilderTrait;

	public function add(Enchantment $enchantment): Wizardry {
		$this->addItem($enchantment);
		return $this;
	}

	public function remove(Enchantment $enchantment): Wizardry {
		$this->removeItem($enchantment);
		return $this;
	}

	/**
	 * Create an Item from unserialized data.
	 */
	protected function createItem(string $class, int $count): Item {
		return new Enchantment(self::createSpell($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 */
	protected function isValidItem(Item $item): bool {
		return $item instanceof Enchantment;
	}
}
