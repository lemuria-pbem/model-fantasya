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
 * A simple signpost that shows a message to visitors in a region.
 */
final class Signpost extends AbstractBuilding
{
	private const TALENT = 1;

	private const SILVER = 50;

	private const WOOD = 1;

	private const STONE = 1;

	private const IRON = 1;

	#[Pure] public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	#[Pure] public function Feed(): int {
		return Building::IS_FREE;
	}

	#[Pure] public function Talent(): int {
		return self::TALENT;
	}

	#[Pure] public function Upkeep(): int {
		return Building::IS_FREE;
	}

	#[Pure] public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}
}
