<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;

/**
 * A sawmill to make wood from trees.
 */
final class Sawmill extends AbstractBuilding
{
	private const FEED = 5;

	private const TALENT = 5;

	private const UPKEEP = 100;

	private const CRAFT = 3;

	private const SILVER = 250;

	private const WOOD = 6;

	private const STONE = 3;

	private const IRON = 5;

	public function Dependency(): Building {
		return self::createBuilding(Cabin::class);
	}

	#[Pure] public function Feed(): int {
		return self::FEED;
	}

	#[Pure] public function Talent(): int {
		return self::TALENT;
	}

	#[Pure] public function Upkeep(): int {
		return self::UPKEEP;
	}

	#[Pure] public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}

	#[Pure] protected function constructionLevel(): int {
		return self::CRAFT;
	}
}
