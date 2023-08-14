<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Singleton;

/**
 * The wizardry is a set of enchantments.
 *
 * @method Enchantment offsetGet(Singleton|string $offset)
 * @method Enchantment current()
 */
class Wizardry extends ItemSet
{
	use BuilderTrait;

	public function add(Enchantment $enchantment): static {
		$this->addItem($enchantment);
		return $this;
	}

	public function remove(Enchantment $enchantment): static {
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
