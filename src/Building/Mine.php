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
use Lemuria\Model\Fantasya\DoubleAbility;
use Lemuria\Model\Fantasya\Talent\Mining;

/**
 * A mine to win iron ore.
 */
final class Mine extends AbstractBuilding
{
	private const FEED = 5;

	private const TALENT = 5;

	private const UPKEEP = 100;

	private const SILVER = 250;

	private const WOOD = 6;

	private const STONE = 3;

	private const IRON = 4;

	public function Dependency(): ?Building {
		return self::createBuilding(Pit::class);
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

	protected function fill(BuildingEffect $buildingEffect): void {
		$mining = self::createTalent(Mining::class);
		$buildingEffect->add(new DoubleAbility($mining));
	}
}
