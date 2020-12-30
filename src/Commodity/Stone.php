<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Commodity;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Lemuria\Commodity;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Material;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Quarrying;
use Lemuria\SingletonTrait;

/**
 * Stone is a basic building material produced from Granite rocks.
 */
final class Stone implements Material
{
	use BuilderTrait;
	use SingletonTrait;

	private const CRAFT = 2;

	private const WEIGHT = 60 * 100;

	private const YIELD = 1;

	private Requirement $craft;

	private Commodity $resource;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	public function getCraft(): Requirement {
		if (!$this->craft) {
			$this->craft = new Requirement(self::createTalent(Quarrying::class), self::CRAFT);
		}
		return $this->craft;
	}

	public function getResource(): Commodity {
		if (!$this->resource) {
			$this->resource = self::createCommodity(Granite::class);
		}
		return $this->resource;
	}

	#[Pure] public function getYield(): int {
		return self::YIELD;
	}
}
