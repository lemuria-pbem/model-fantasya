<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * An offer on the market describes the price of a commodity.
 */
class Offer
{
	protected Commodity $commodity;

	private int $price;

	/**
	 * Create an offer.
	 *
	 * @param Commodity $commodity
	 * @param int $price
	 */
	public function __construct(Commodity $commodity, int $price = 0) {
		$this->commodity = $commodity;
		$this->price     = $price;
	}

	/**
	 * Get the commodity.
	 *
	 * @return Commodity
	 */
	public function Commodity(): Commodity {
		return $this->commodity;
	}

	/**
	 * Get the price.
	 *
	 * @return int
	 */
	public function Price(): int {
		return $this->price;
	}

	/**
	 * Set the price.
	 *
	 * @param int $price
	 * @return Offer
	 */
	public function setPrice(int $price): Offer {
		$this->price = $price;
		return $this;
	}
}
