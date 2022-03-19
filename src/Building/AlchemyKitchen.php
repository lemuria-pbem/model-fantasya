<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\BuildingEffect;
use Lemuria\Model\Fantasya\Commodity\Gold;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Talent\Alchemy;

/**
 * A kitchen for alchemists to help them brew their potions.
 */
final class AlchemyKitchen extends AbstractBuilding
{
	private const TALENT = 6;

	private const UPKEEP = 300;

	private const FEED = 10;

	private const SILVER = 300;

	private const WOOD = 3;

	private const STONE = 5;

	private const IRON = 3;

	private const GOLD = 1;

	private const USEFUL_SIZE = 5;

	public function Dependency(): ?Building {
		return self::createBuilding(Stronghold::class);
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
		return self::USEFUL_SIZE;
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON, Gold::class => self::GOLD];
	}

	protected function fill(BuildingEffect $buildingEffect): void {
		$alchemy = self::createTalent(Alchemy::class);
		$buildingEffect->add(new Modification($alchemy, 1));
	}
}
