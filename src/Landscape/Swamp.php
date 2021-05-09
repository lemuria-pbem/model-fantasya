<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;

/**
 * A swamp is like a plain, but there are many moors and few peasants can make it their home.
 */
final class Swamp extends AbstractLandscape
{
	private const HERBS = [Bubblemorel::class, Bugleweed::class, Knotroot::class];

	private const ROAD_STONES = 250;

	private const WORKPLACES = 2000;

	private static ?array $herbs = null;

	public function Herbs(): array {
		if (!self::$herbs) {
			self::$herbs = $this->createHerbs(self::HERBS);
		}
		return self::$herbs;
	}

	#[Pure] public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	#[Pure] public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
