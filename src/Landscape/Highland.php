<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * The stony highland is similar to a plain, with roughly half the number of workplaces.
 */
final class Highland extends AbstractLandscape
{
	private const ROAD_STONES = 100;

	private const WORKPLACES = 4000;

	#[Pure] public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
