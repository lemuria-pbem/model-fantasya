<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;

/**
 * A swamp is like a plain, but there are many moors and few peasants can make it their home.
 */
final class Swamp extends AbstractLandscape
{
	/**
	 * @type array<string>
	 */
	private const array HERBS = [Bubblemorel::class, Bugleweed::class, Knotroot::class];

	private const int ROAD_STONES = 250;

	private const int WORKPLACES = 2000;

	private static ?array $herbs = null;

	public function Herbs(): array {
		if (!self::$herbs) {
			self::$herbs = $this->createHerbs(self::HERBS);
		}
		return self::$herbs;
	}

	public function RoadStones(): int {
		return self::ROAD_STONES;
	}

	public function Workplaces(): int {
		return self::WORKPLACES;
	}
}
