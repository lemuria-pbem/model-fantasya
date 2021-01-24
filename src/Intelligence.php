<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\Pure;

/**
 * Helper class for region information.
 */
final class Intelligence
{
	#[Pure]	public function __construct(private Region $region) {
	}

	/**
	 * Get the parties that are currently represented in the region.
	 */
	public function getParties(): Gathering {
		$parties = new Gathering();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			$parties->add($unit->Party());
		}
		return $parties;
	}

	/**
	 * Get the units of a party that are in the region.
	 */
	public function getUnits(Party $party): People {
		$units = new People();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			if ($unit->Party() === $party) {
				$units->add($unit);
			}
		}
		return $units;
	}

	/**
	 * Get the guards of the region.
	 */
	public function getGuards(): People {
		$guards = new People();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			if ($unit->IsGuarding()) {
				$guards->add($unit);
			}
		}
		return $guards;
	}
}
