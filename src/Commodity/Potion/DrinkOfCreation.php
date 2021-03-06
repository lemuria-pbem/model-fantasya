<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Herb\Gapgrowth;
use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;
use Lemuria\Model\Fantasya\Commodity\Herb\Sandreeker;

final class DrinkOfCreation extends AbstractPotion
{
	public const PERSONS = 10;

	private const LEVEL = 2;

	private const WEEKS = 3;

	private const INGREDIENTS = [Gapgrowth::class, IceBegonia::class, Sandreeker::class];

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
