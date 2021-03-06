<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\Immutable;
use JetBrains\PhpStorm\Pure;

/**
 * An offer on the market describes the price of a commodity.
 */
class Offer
{
	#[Pure] public function __construct(#[Immutable] private Commodity $commodity, private int $price = 0) {
	}

	#[Pure] public function Commodity(): Commodity {
		return $this->commodity;
	}

	#[Pure] public function Price(): int {
		return $this->price;
	}

	public function setPrice(int $price): Offer {
		$this->price = $price;
		return $this;
	}
}
