<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

/**
 * A glacier is home to only a few peasants.
 */
final class Glacier extends AbstractLandscape
{
	private const ROAD_STONES = 350;

	private const WORKPLACES = 100;

	#[Pure] public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
