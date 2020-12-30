<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A plain is a relatively flat landscape.
 */
class Plain extends AbstractLandscape
{
	private const WORKPLACES = 10000;

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
