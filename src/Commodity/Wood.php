<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Material;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Woodchopping;
use Lemuria\SingletonTrait;

/**
 * Wood is made from trees.
 */
final class Wood implements Material
{
	use BuilderTrait;
	use SingletonTrait;

	private const CRAFT = 1;

	private const WEIGHT = 5 * 100;

	private const YIELD = 5;

	private const REGAIN = 0.6;

	private Requirement $craft;

	private Commodity $resource;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$this->craft = new Requirement(self::createTalent(Woodchopping::class), self::CRAFT);
		}
		return $this->craft;
	}

	public function getResource(): Commodity {
		if (!$this->resource) {
			$this->resource = self::createCommodity(Tree::class);
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
