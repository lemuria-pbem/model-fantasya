<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;

/**
 * A glacier is home to only a few peasants.
 */
final class Glacier extends AbstractLandscape
{
	/**
	 * @type array<string>
	 */
	private const array HERBS = [IceBegonia::class, Snowcrystal::class, WhiteHemlock::class];

	private const int ROAD_STONES = 350;

	private const int WORKPLACES = 150;

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
