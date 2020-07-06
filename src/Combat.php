<?php
namespace Lemuria\Model\Lemuria;

/**
 * A helper class for combat properties.
 */
final class Combat
{
	public const AGGRESSIVE = 5;

	public const FRONT = 4;

	public const BACK = 3;

	public const DEFENSIVE = 2;

	public const BYSTANDER = 1;

	public const REFUGEE = 0;

	/**
	 * Check if a battle row value is valid.
	 *
	 * @param int $battleRow
	 * @return bool
	 */
	public static function isBattleRow(int $battleRow): bool {
		return $battleRow >= self::REFUGEE && $battleRow <= self::AGGRESSIVE;
	}
}
