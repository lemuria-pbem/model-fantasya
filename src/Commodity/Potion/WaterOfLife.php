<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\Knotroot;
use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;

final class WaterOfLife extends AbstractPotion
{
	public final const int SAPLINGS = 10;

	private const int LEVEL = 2;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [Knotroot::class, Rockweed::class, SpiderIvy::class];

	public function Level(): int {
		return self::LEVEL;
	}

	/**
	 * @return array<string, int>
	 */
	protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
