<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Jewelry;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Gold;

/**
 * A golden ring that can be turned into a magic ring.
 */
class GoldRing extends AbstractJewelry
{
	public const WEIGHT = 10;

	private const CRAFT = 3;

	private const GOLD = 1;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	/** @noinspection PhpArrayShapeAttributeCanBeAddedInspection */
	#[Pure] protected function material(): array {
		return [Gold::class => self::GOLD];
	}

	protected function getCraftLevel(): int {
		return self::CRAFT;
	}
}
