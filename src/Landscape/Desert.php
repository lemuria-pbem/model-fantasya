<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\Peyote;
use Lemuria\Model\Fantasya\Commodity\Herb\Sandreeker;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;

/**
 * A desert is a landscape full of sand, where fauna and flora is sparse.
 */
final class Desert extends AbstractLandscape
{
	/**
	 * @type array<string>
	 */
	private const array HERBS = [Peyote::class, Sandreeker::class, Waterfinder::class];

	private const int ROAD_STONES = 150;

	private const int WORKPLACES = 500;

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
