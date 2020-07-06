<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use Lemuria\Item;

/**
 * A quantity is an item of some commodity.
 */
class Quantity extends Item
{
	/**
	 * Create a quantity of some product.
	 *
	 * @param Commodity $commodity
	 * @param int $count
	 */
	public function __construct(Commodity $commodity, int $count = 1) {
		parent::__construct($commodity, $count);
	}

	/**
	 * Get the commodity.
	 *
	 * @return Commodity
	 */
	public function Commodity(): Commodity {
		$commodity = $this->getObject(); /* @var Commodity $commodity */
		return $commodity;
	}

	/**
	 * Get the quantities' total weight.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return $this->Count() * $this->Commodity()->Weight();
	}

	/**
	 * Add a quantity.
	 *
	 * @param Quantity $quantity
	 * @return Quantity
	 */
	public function add(Quantity $quantity): Quantity {
		$this->addItem($quantity);

		return $this;
	}

	/**
	 * Remove a quantity.
	 *
	 * @param Quantity $quantity
	 * @return Quantity
	 */
	public function remove(Quantity $quantity): Quantity {
		$this->removeItem($quantity);

		return $this;
	}
}
