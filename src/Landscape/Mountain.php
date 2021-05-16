<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\Gapgrowth;
use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;

/**
 * The mountain is a region for few peasants, but precious resources can be found there.
 */
final class Mountain extends AbstractLandscape
{
	private const HERBS = [CaveLichen::class, Gapgrowth::class, Rockweed::class];

	private const ROAD_STONES = 200;

	private const WORKPLACES = 1000;

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
