<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\BuildingEffect;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Talent\Quarrying;

/**
 * A shack for stone masons that improves quarrying.
 */
final class Shack extends AbstractBuilding
{
	private const FEED = 5;

	private const TALENT = 3;

	private const SILVER = 100;

	private const WOOD = 2;

	private const STONE = 3;

	private const IRON = 2;

	#[Pure] public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	#[Pure] public function Feed(): int {
		return self::FEED;
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

	protected function fill(BuildingEffect $buildingEffect): void {
		$quarrying = self::createTalent(Quarrying::class);
		$buildingEffect->add(new Modification($quarrying, 1));
	}
}
