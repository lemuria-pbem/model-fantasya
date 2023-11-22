<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Navigable;

abstract class AbstractNavigable extends AbstractLandscape implements Navigable
{
	private const int ROAD_STONES = 0;

	private const int WORKPLACES = 0;

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
