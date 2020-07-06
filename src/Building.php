<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * A building is an artifact than can be entered by units.
 */
interface Building extends Artifact
{
	const IS_FREE = 0;

	const IS_INDEPENDENT = null;

	const IS_UNLIMITED = 0;

	/**
	 * Get the building that must exist as a precondition.
	 *
	 * @return Building|null
	 */
	public function Dependency(): ?Building;

	/**
	 * Get the additional feed for every person of a unit that has entered the building.
	 *
	 * @return int
	 */
	public function Feed(): int;

	/**
	 * Get the talent level needed to create the building.
	 *
	 * @return int
	 */
	public function Talent(): int;

	/**
	 * Get the amount of silver to maintain the building's function.
	 *
	 * @return int
	 */
	public function Upkeep(): int;

	/**
	 * Get the minimum size the building must have.
	 *
	 * @return int
	 */
	public function UsefulSize(): int;
}
