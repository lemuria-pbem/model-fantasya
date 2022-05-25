<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\Model\Fantasya\BuildingEffect;
use Lemuria\Model\Fantasya\Commodity\Iron;
use Lemuria\Model\Fantasya\Commodity\Silver;
use Lemuria\Model\Fantasya\Commodity\Stone;
use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Modification;
use Lemuria\Model\Fantasya\Talent\Armory;

/**
 * A saddlery that help units create armor and shields.
 */
final class Saddlery extends AbstractBuilding
{
	private const TALENT = 4;

	private const UPKEEP = 100;

	private const FEED = 5;

	private const SILVER = 250;

	private const WOOD = 4;

	private const STONE = 2;

	private const IRON = 6;

	public function Dependency(): ?Building {
		return self::createBuilding(Palace::class);
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
		return Building::IS_UNLIMITED;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}

	protected function fill(BuildingEffect $buildingEffect): void {
		$armory = self::createTalent(Armory::class);
		$buildingEffect->add(new Modification($armory, 1));
	}
}
