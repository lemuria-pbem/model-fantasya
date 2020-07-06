<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Ship;

use Lemuria\Model\Lemuria\Commodity\Wood;
use Lemuria\Model\Lemuria\Factory\BuilderTrait;
use Lemuria\Model\Lemuria\Ship;
use Lemuria\Model\Lemuria\ArtifactTrait;
use Lemuria\Model\Lemuria\Requirement;
use Lemuria\Model\Lemuria\Talent\Shipbuilding;

/**
 * Base class for any ship.
 */
abstract class AbstractShip implements Ship
{
	use ArtifactTrait;
	use BuilderTrait;

	private Requirement $craft;

	/**
	 * Get the needed craft to create this artifact.
	 *
	 * @return Requirement
	 */
	public function getCraft(): Requirement {
		if (!$this->craft) {
			$talent      = self::createTalent(Shipbuilding::class);
			$this->craft = new Requirement($talent, $this->shipbuildingLevel());
		}
		return $this->craft;
	}

	/**
	 * Get the amount of wood.
	 *
	 * @return int
	 */
	abstract protected function wood(): int;

	/**
	 * Get the material.
	 *
	 * @return array(string=>int)
	 */
	protected function material(): array {
		return [Wood::class => $this->wood()];
	}

	/**
	 * Get the minimum skill in Shipbuilding to build this ship.
	 * The skill is equal to the captain's skill.
	 *
	 * @return int
	 */
	protected function shipbuildingLevel(): int {
		return $this->Captain();
	}
}
