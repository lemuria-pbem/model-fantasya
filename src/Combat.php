<?php
namespace Lemuria\Model\Fantasya;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

/**
 * A helper class for combat properties.
 */
abstract class Combat
{
	public const AGGRESSIVE = 5;

	public const FRONT = 4;

	public const BACK = 3;

	public const DEFENSIVE = 2;

	public const BYSTANDER = 1;

	public const REFUGEE = 0;

	/**
	 * Check if a battle row value is valid.
	 */
	#[Pure] public static function isBattleRow(#[ExpectedValues(valuesFromClass: self::class)] int $battleRow): bool {
		return $battleRow >= self::REFUGEE && $battleRow <= self::AGGRESSIVE;
	}
}
