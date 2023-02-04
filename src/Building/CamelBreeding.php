<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Camel;

/**
 * A camel breeding farm.
 */
final class CamelBreeding extends AbstractBreeding
{
	public function Animal(): Camel {
		/** @var Camel $animal */
		$animal = self::createCommodity(Camel::class);
		return $animal;
	}
}
