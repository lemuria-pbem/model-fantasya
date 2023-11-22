<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

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
	private const int TALENT = 6;

	private const int UPKEEP = 300;

	private const int FEED = 10;

	private const int SILVER = 300;

	private const int WOOD = 3;

	private const int STONE = 5;

	private const int IRON = 3;

	private const int GOLD = 1;

	private const int USEFUL_SIZE = 5;

	public function Dependency(): ?Building {
		return self::createBuilding(Stronghold::class);
	}

	public function Feed(): int {
		return self::FEED;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return self::UPKEEP;
	}

	public function UsefulSize(): int {
		return self::USEFUL_SIZE;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON, Gold::class => self::GOLD];
	}

	protected function fill(BuildingEffect $buildingEffect): void {
		$alchemy = self::createTalent(Alchemy::class);
		$buildingEffect->add(new Modification($alchemy, 1));
	}
}
