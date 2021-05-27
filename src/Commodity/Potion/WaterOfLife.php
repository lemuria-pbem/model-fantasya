<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;

final class WaterOfLife extends AbstractPotion
{
	public const SAPLINGS = 10;

	private const LEVEL = 2;

	private const INGREDIENTS = [Knotroot::class, Rockweed::class, SpiderIvy::class];

	#[Pure] public function Level(): int {
		return self::LEVEL;
	}

	/**
	 * @return array(string=>int)
	 */
	#[Pure] protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
