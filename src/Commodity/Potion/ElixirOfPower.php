<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\Owlsgaze;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;
use Lemuria\Model\Fantasya\Commodity\Herb\SpiderIvy;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;

final class ElixirOfPower extends AbstractPotion
{
	public final const int PERSONS = 10;

	private const int LEVEL = 4;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [CaveLichen::class, Owlsgaze::class, Snowcrystal::class, SpiderIvy::class, Waterfinder::class];

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
