<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\FjordFungus;
use Lemuria\Model\Fantasya\Commodity\Herb\Mandrake;
use Lemuria\Model\Fantasya\Commodity\Herb\Windbag;

/**
 * The stony highland is similar to a plain, with roughly half the number of workplaces.
 */
final class Highland extends AbstractLandscape
{
	/**
	 * @type array<string>
	 */
	private const array HERBS = [FjordFungus::class, Mandrake::class, Windbag::class];

	private const int ROAD_STONES = 100;

	private const int WORKPLACES = 4000;

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
