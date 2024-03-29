<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\Elvendear;
use Lemuria\Model\Fantasya\Commodity\Herb\Mandrake;
use Lemuria\Model\Fantasya\Commodity\Herb\Snowcrystal;

final class PeasantJoy extends AbstractPotion
{
	public final const int PEASANTS = 1000;

	private const int LEVEL = 3;

	private const int WEEKS = 3;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [Bubblemorel::class, Elvendear::class, Mandrake::class, Snowcrystal::class];

	public function Level(): int {
		return self::LEVEL;
	}

	public function Weeks(): int {
		return self::WEEKS;
	}

	/**
	 * @return array<string, int>
	 */
	protected function material(): array {
		return array_fill_keys(self::INGREDIENTS, 1);
	}
}
