<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\Gapgrowth;
use Lemuria\Model\Fantasya\Commodity\Herb\IceBegonia;
use Lemuria\Model\Fantasya\Commodity\Herb\Sandreeker;

final class DrinkOfCreation extends AbstractPotion
{
	public final const PERSONS = 10;

	private const LEVEL = 2;

	private const WEEKS = 3;

	private const INGREDIENTS = [Gapgrowth::class, IceBegonia::class, Sandreeker::class];

	public function Level(): int {
		return self::LEVEL;
	}

	public function Weeks(): int {
		return self::WEEKS;
	}

	/**
	 * @return array(string=>int)
	 */
	protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
