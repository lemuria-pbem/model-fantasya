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
 * A cabin that improves woodchopping.
 */
final class Cabin extends AbstractBuilding
{
	private const TALENT = 3;

	private const UPKEEP = 50;

	private const CRAFT = 1;

	private const SILVER = 100;

	private const WOOD = 5;

	private const STONE = 2;

	private const IRON = 1;

	#[Pure] public function Dependency(): Building {
		return Building::IS_INDEPENDENT;
	}

	#[Pure] public function Feed(): int {
		return Building::IS_FREE;
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
