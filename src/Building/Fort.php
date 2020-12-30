<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The second level of a castle.
 */
final class Fort extends AbstractCastle
{
	public const MAX_SIZE = 9;

	private const DEFENSE = 0;

	private const MIN_SIZE = 2;

	private const TALENT = 2;

	private const WAGE = 12;

	private const CRAFT = 2;

	#[Pure] public function Defense(): int {
		return self::DEFENSE;
	}

	#[Pure] public function MaxSize(): int {
		return self::MAX_SIZE;
	}

	#[Pure] public function MinSize(): int {
		return self::MIN_SIZE;
	}

	#[Pure] public function Talent(): int {
		return self::TALENT;
	}

	public function Upgrade(): Castle {
		return self::createCastle(Tower::class);
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}

	#[Pure] protected function constructionLevel(): int {
		return self::CRAFT;
	}
}
