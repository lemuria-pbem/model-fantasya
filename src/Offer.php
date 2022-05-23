<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * An offer on the market describes the price of a commodity.
 */
class Offer
{
	public function __construct(private readonly Luxury $commodity, private int $price = 0) {
	}

	public function Commodity(): Luxury {
		return $this->commodity;
	}

	public function Price(): int {
		return $this->price;
	}

	public function setPrice(int $price): Offer {
		$this->price = $price;
		return $this;
	}
}
