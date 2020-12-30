<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

use Lemuria\Item;
use Lemuria\ItemSet;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;

/**
 * Goods are sets of quantities.
 */
class Goods extends ItemSet
{
	use BuilderTrait;

	/**
	 * Add a quantity of a product.
	 */
	public function add(Quantity $quantity): Goods {
		$this->addItem($quantity);

		return $this;
	}

	/**
	 * Remove a quantity of a product.
	 */
	public function remove(Quantity $quantity): Goods {
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
