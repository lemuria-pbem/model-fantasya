<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Wood;
use Lemuria\Model\Fantasya\Shield;

/**
 * A handy shield made of wood.
 */
final class Woodshield extends AbstractProtection implements Shield
{
	private const CRAFT = 2;

	private const WEIGHT = 2 * 100;

	private const WOOD = 1;

	private const BLOCK = 4;

	#[Pure] public function Weight(): int {
		return self::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return self::BLOCK;
	}

	/**
	 * @noinspection PhpArrayShapeAttributeCanBeAddedInspection
	 */
	#[Pure] protected function material(): array {
		return [Wood::class => self::WOOD];
	}

	#[Pure] protected function craft(): int {
		return self::CRAFT;
	}
}
