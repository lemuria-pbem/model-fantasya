<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Animal;
use Lemuria\Model\Fantasya\Commodity\Horse;

/**
 * A horse breeding farm.
 */
final class HorseBreeding extends AbstractBreeding
{
	public function Animal(): Animal {
		/** @var Animal $animal */
		$animal = self::createCommodity(Horse::class);
		return $animal;
	}
}
