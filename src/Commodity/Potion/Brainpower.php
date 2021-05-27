<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;
use Lemuria\Model\Fantasya\Commodity\Herb\Windbag;

final class Brainpower extends AbstractPotion
{
	public const PERSONS = 10;

	private const LEVEL = 2;

	private const WEEKS = 3;

	private const INGREDIENTS = [Rockweed::class, Waterfinder::class, Windbag::class];

	#[Pure] public function Level(): int {
		return self::LEVEL;
	}

	#[Pure] public function Weeks(): int {
		return self::WEEKS;
	}

	/**
	 * @return array(string=>int)
	 */
	#[Pure] protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
