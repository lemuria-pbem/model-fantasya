<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Jewelry;

use Lemuria\Model\Fantasya\Commodity\Gold;

/**
 * A golden ring that can be turned into a magic ring.
 */
class GoldRing extends AbstractJewelry
{
	public const int WEIGHT = 10;

	private const int CRAFT = 3;

	private const int GOLD = 1;

	public function Weight(): int {
		return self::WEIGHT;
	}

	protected function material(): array {
		return [Gold::class => self::GOLD];
	}

	protected function getCraftLevel(): int {
		return self::CRAFT;
	}
}
