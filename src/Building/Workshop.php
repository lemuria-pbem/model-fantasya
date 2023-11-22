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
use Lemuria\Model\Fantasya\Talent\Carriagemaking;

/**
 * A workshop that help units build carriages and catapults.
 */
final class Workshop extends AbstractBuilding
{
	private const int TALENT = 4;

	private const int UPKEEP = 100;

	private const int FEED = 5;

	private const int SILVER = 250;

	private const int WOOD = 6;

	private const int STONE = 4;

	private const int IRON = 2;

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
		$carriagemaking = self::createTalent(Carriagemaking::class);
		$buildingEffect->add(new Modification($carriagemaking, 1));
	}
}
