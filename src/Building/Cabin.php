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
use Lemuria\Model\Fantasya\Talent\Woodchopping;

/**
 * A cabin that improves woodchopping.
 */
final class Cabin extends AbstractBuilding
{
	private const int TALENT = 3;

	private const int FEED = 5;

	private const int SILVER = 100;

	private const int WOOD = 5;

	private const int STONE = 2;

	private const int IRON = 1;

	public function Dependency(): ?Building {
		return Building::IS_INDEPENDENT;
	}

	public function Feed(): int {
		return self::FEED;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Upkeep(): int {
		return Building::IS_FREE;
	}

	public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}

	protected function fill(BuildingEffect $buildingEffect): void {
		$woodchopping = self::createTalent(Woodchopping::class);
		$buildingEffect->add(new Modification($woodchopping, 1));
	}
}
