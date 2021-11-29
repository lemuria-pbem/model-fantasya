<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Armature;
use Lemuria\Model\Fantasya\Commodity\Iron;

/**
 * A full body armor made of iron.
 */
final class Armor extends AbstractProtection implements Armature
{
	public const WEIGHT = 4 * 100;

	public const BLOCK = 7;

	private const CRAFT = 4;

	private const IRON = 5;

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
		return [Iron::class => self::IRON];
	}

	#[Pure] protected function craft(): int {
		return self::CRAFT;
	}
}
