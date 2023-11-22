<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Potion;

use Lemuria\Model\Fantasya\Commodity\Herb\Bubblemorel;
use Lemuria\Model\Fantasya\Commodity\Herb\FjordFungus;

final class GoliathWater extends AbstractPotion
{
	public final const int PERSONS = 10;

	private const int LEVEL = 1;

	/**
	 * @type array<string>
	 */
	private const array INGREDIENTS = [Bubblemorel::class, FjordFungus::class];

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
