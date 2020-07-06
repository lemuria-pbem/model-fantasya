<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use Lemuria\Exception\LemuriaException;
use Lemuria\Model\Lemuria\Building;
use Lemuria\Model\Lemuria\Commodity\Stone;

/**
 * Base class for any castle.
 */
abstract class AbstractCastle extends AbstractBuilding implements Castle
{
	/**
	 * Get the Castle for a given size.
	 *
	 * @param int $size
	 * @return Castle
	 */
	public static function forSize(int $size): Castle {
		if ($size <= 0) {
			throw new LemuriaException('Size must be greater than zero.');
		}
		$class = self::getClassForSize($size);
		/* @var Castle $castle */
		$castle = self::createBuilding($class);
		return $castle;
	}

	/**
	 * Get the building that must exist as a precondition.
	 *
	 * @return Building|null
	 */
	public function Dependency(): Building {
		return Building::IS_INDEPENDENT;
	}

	/**
	 * Get the additional feed for every person of a unit that has entered the building.
	 *
	 * @return int
	 */
	public function Feed(): int {
		return Building::IS_FREE;
	}

	/**
	 * Get the amount of silver to maintain the building's function.
	 *
	 * @return int
	 */
	public function Upkeep(): int {
		return Building::IS_FREE;
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
		return [Stone::class => 1];
	}

	/**
	 * Get the Castle class for a specific size.
	 *
	 * @param int $size
	 * @return string
	 */
	private static function getClassForSize(int $size): string {
		if ($size <= Site::MAX_SIZE) {
			return Site::class;
		}
		if ($size <= Fort::MAX_SIZE) {
			return Fort::class;
		}
		if ($size <= Tower::MAX_SIZE) {
			return Tower::class;
		}
		if ($size <= Palace::MAX_SIZE) {
			return Palace::class;
		}
		if ($size <= Stronghold::MAX_SIZE) {
			return Stronghold::class;
		}
		return Citadel::class;
	}
}
