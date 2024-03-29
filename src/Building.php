<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * A building is an artifact than can be entered by units.
 */
interface Building extends Artifact
{
	public final const int IS_FREE = 0;

	public final const null IS_INDEPENDENT = null;

	public final const int IS_UNLIMITED = 0;

	/**
	 * Get the building that must exist as a precondition.
	 */
	public function Dependency(): ?Building;

	/**
	 * Get the additional feed for every person of a unit that has entered the building.
	 */
	public function Feed(): int;

	/**
	 * Get the maximum allowed size of the building.
	 */
	public function MaxSize(): int;

	/**
	 * Get the talent level needed to create the building.
	 */
	public function Talent(): int;

	/**
	 * Get the amount of silver to maintain the building's function.
	 */
	public function Upkeep(): int;

	/**
	 * Get the minimum size the building must have.
	 */
	public function UsefulSize(): int;

	public function BuildingEffect(): BuildingEffect;

	public function StructurePoints(): int;

	/**
	 * Get the best fitting building for given size of this building.
	 */
	public function correctBuilding(int $size): Building;

	/**
	 * Get the best fitting size for given size of this building.
	 */
	public function correctSize(int $size): int;
}
