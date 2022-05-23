<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

/**
 * The ocean, full of water.
 */
final class Ocean extends AbstractLandscape
{
	private const ROAD_STONES = 0;

	private const WORKPLACES = 0;

	private static array $herbs = [];

	public function Herbs(): array {
		return self::$herbs;
	}

	public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
