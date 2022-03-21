<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Commodity\Camel;
use Lemuria\Model\Fantasya\Commodity;

/**
 * A camel breeding farm.
 */
final class CamelBreeding extends AbstractBreeding
{
	public function Animal(): Commodity {
		return self::createCommodity(Camel::class);
	}
}
