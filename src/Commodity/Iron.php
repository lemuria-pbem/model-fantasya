<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Material;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Mining;
use Lemuria\SingletonTrait;

/**
 * Iron is made from Ore mined in mountainous regions.
 */
final class Iron implements Material
{
	use BuilderTrait;
	use SingletonTrait;

	private const CRAFT = 3;

	private const WEIGHT = 5 * 100;

	private const YIELD = 1;

	private Requirement $craft;

	private Commodity $resource;

	/**
	 * Get the weight of a product.
	 *
	 * @return int
	 */
	public function Weight(): int {
		return self::WEIGHT;
	}

	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement {
		if (!$this->craft) {
			$this->craft = new Requirement(self::createTalent(Mining::class), self::CRAFT);
		}
		return $this->craft;
	}

	/**
	 * Get the resource to create this material.
	 *
	 * @return Commodity
	 */
	public function getResource(): Commodity {
		if (!$this->resource) {
			$this->resource = self::createCommodity(Ore::class);
		}
		return $this->resource;
	}

	/**
	 * Get the number of items from one resource.
	 *
	 * @return int
	 */
	public function getYield(): int {
		return self::YIELD;
	}
}
