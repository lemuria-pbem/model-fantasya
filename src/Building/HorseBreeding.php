<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Horse;

/**
 * A horse breeding farm.
 */
final class HorseBreeding extends AbstractBreeding
{
	public function Animal(): Horse {
		/** @var Horse $animal */
		$animal = self::createCommodity(Horse::class);
		return $animal;
	}
}
