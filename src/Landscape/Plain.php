<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\Flatroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Owlsgaze;
use Lemuria\Model\Fantasya\Commodity\Herb\TangyTemerity;

/**
 * A plain is a relatively flat landscape.
 */
class Plain extends AbstractLandscape
{
	private const HERBS = [Flatroot::class, Owlsgaze::class, TangyTemerity::class];

	private const ROAD_STONES = 50;

	private const WORKPLACES = 10000;

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
