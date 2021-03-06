<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Pure;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;

/**
 * Resources are sets of quantities.
 */
class Resources extends ItemSet
{
	use BuilderTrait;

	public function add(Quantity $quantity): Resources {
		$this->addItem($quantity);
		return $this;
	}

	public function remove(Quantity $quantity): Resources {
		$this->removeItem($quantity);
		return $this;
	}

	/**
	 * Create an Item from unserialized data.
	 */
	protected function createItem(string $class, int $count): Item {
		return new Quantity(self::createCommodity($class), $count);
	}

	/**
	 * Check if an item is valid for this set.
	 */
	#[Pure] protected function isValidItem(Item $item): bool {
		return $item instanceof Quantity;
	}
}
