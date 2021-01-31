<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

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

	private const REGAIN = 0.4;

	private Requirement $craft;

	private Commodity $resource;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$this->craft = new Requirement(self::createTalent(Mining::class), self::CRAFT);
		}
		return $this->craft;
	}

	public function getResource(): Commodity {
		if (!$this->resource) {
			$this->resource = self::createCommodity(Ore::class);
		}
		return $this->resource;
	}

	#[Pure] public function getYield(): int {
		return self::YIELD;
	}

	#[Pure] public function getRegain(): float {
		return self::REGAIN;
	}
}
