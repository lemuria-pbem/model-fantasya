<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\Rockweed;
use Lemuria\Model\Fantasya\Commodity\Herb\Waterfinder;
use Lemuria\Model\Fantasya\Commodity\Herb\Windbag;

final class Brainpower extends AbstractPotion
{
	public final const int PERSONS = 10;

	private const int LEVEL = 2;

	private const int WEEKS = 3;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [Rockweed::class, Waterfinder::class, Windbag::class];

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
