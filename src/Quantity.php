<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

use Lemuria\Item;

/**
 * A quantity is an item of some commodity.
 */
class Quantity extends Item
{
	/**
	 * Create a quantity of some product.
	 */
	#[Pure] public function __construct(Commodity $commodity, int $count = 1) {
		parent::__construct($commodity, $count);
	}

	#[Pure] public function Commodity(): Commodity {
		/** @var Commodity $commodity */
		$commodity = $this->getObject();
		return $commodity;
	}

	/**
	 * Get the quantities' total weight.
	 */
	#[Pure] public function Weight(): int {
		return $this->Count() * $this->Commodity()->Weight();
	}

	public function add(Quantity $quantity): Quantity {
		$this->addItem($quantity);

		return $this;
	}

	public function remove(Quantity $quantity): Quantity {
		$this->removeItem($quantity);

		return $this;
	}
}
