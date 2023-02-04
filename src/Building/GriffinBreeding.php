<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Griffin;

/**
 * A griffin breeding farm.
 */
final class GriffinBreeding extends AbstractBreeding
{
	public function Animal(): Griffin {
		/** @var Griffin $animal */
		$animal = self::createCommodity(Griffin::class);
		return $animal;
	}
}
