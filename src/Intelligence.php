<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria;

/**
 * Helper class for region information.
 */
final class Intelligence
{
	/**
	 * @var Region
	 */
	private Region $region;

	/**
	 * Create new intelligence.
	 *
	 * @param Region $region
	 */
	public function __construct(Region $region) {
		$this->region = $region;
	}

	/**
	 * Get the guards of the region.
	 *
	 * @return People
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
