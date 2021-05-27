<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Bugleweed;
use Lemuria\Model\Fantasya\Commodity\Herb\CaveLichen;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\Flatroot;
use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;

final class HealingPotion extends AbstractPotion
{
	private const LEVEL = 4;

	private const INGREDIENTS = [Bugleweed::class, CaveLichen::class, Elvendear::class, Flatroot::class, IceBegonia::class];

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
