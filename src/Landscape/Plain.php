<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A plain is a relatively flat landscape.
 */
class Plain extends AbstractLandscape
{
	private const ROAD_STONES = 50;

	private const WORKPLACES = 10000;

	#[Pure] public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
