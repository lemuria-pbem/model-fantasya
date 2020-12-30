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
