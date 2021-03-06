<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\Mandrake;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;

final class PeasantJoy extends AbstractPotion
{
	public const PEASANTS = 1000;

	private const LEVEL = 3;

	private const WEEKS = 3;

	private const INGREDIENTS = [Bubblemorel::class, Elvendear::class, Mandrake::class, Snowcrystal::class];

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
