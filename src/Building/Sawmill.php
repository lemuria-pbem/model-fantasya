<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use Lemuria\Model\Lemuria\Building;
use Lemuria\Model\Lemuria\Commodity\Iron;
use Lemuria\Model\Lemuria\Commodity\Silver;
use Lemuria\Model\Lemuria\Commodity\Stone;
use Lemuria\Model\Lemuria\Commodity\Wood;

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

	/**
	 * Get the building that must exist as a precondition.
	 *
	 * @return Building|null
	 */
	public function Dependency(): Building {
		return self::createBuilding(Tower::class);
	}

	/**
	 * Get the additional feed for every person of a unit that has entered the building.
	 *
	 * @return int
	 */
	public function Feed(): int {
		return self::FEED;
	}

	/**
	 * Get the talent level needed to create the building.
	 *
	 * @return int
	 */
	public function Talent(): int {
		return self::TALENT;
	}

	/**
	 * Get the amount of silver to maintain the building's function.
	 *
	 * @return int
	 */
	public function Upkeep(): int {
		return self::UPKEEP;
	}

	/**
	 * Get the minimum size the building must have.
	 *
	 * @return int
	 */
	public function UsefulSize(): int {
		return Building::IS_UNLIMITED;
	}

	/**
	 * Get the material.
	 *
	 * @return array(Commodity=>int)
	 */
	protected function material(): array {
		return [Silver::class => self::SILVER, Wood::class => self::WOOD, Stone::class => self::STONE, Iron::class => self::IRON];
	}

	/**
	 * Get the minimum skill in Construction to build this building.
	 *
	 * @return int
	 */
	protected function constructionLevel(): int {
		return self::CRAFT;
	}
}
