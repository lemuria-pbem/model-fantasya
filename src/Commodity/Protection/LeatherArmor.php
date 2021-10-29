<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Elephant;

/**
 * An armor made of Elephant leather.
 */
final class LeatherArmor extends AbstractProtection implements Armature
{
	private const CRAFT = 3;

	private const WEIGHT = 1 * 100;

	private const ELEPHANT = 1;

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
		return [Elephant::class => self::ELEPHANT];
	}

	#[Pure] protected function craft(): int {
		return self::CRAFT;
	}
}
