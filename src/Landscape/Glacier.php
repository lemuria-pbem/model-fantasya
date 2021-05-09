<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;
use Lemuria\Model\Fantasya\Commodity\Herb\WhiteHemlock;

/**
 * A glacier is home to only a few peasants.
 */
final class Glacier extends AbstractLandscape
{
	private const HERBS = [IceBegonia::class, Snowcrystal::class, WhiteHemlock::class];

	private const ROAD_STONES = 350;

	private const WORKPLACES = 100;

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
