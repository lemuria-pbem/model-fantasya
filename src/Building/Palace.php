<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The fourth level of a castle.
 */
final class Palace extends AbstractCastle
{
	public const MAX_SIZE = 249;

	private const DEFENSE = 2;

	private const MIN_SIZE = 50;

	private const TALENT = 4;

	private const WAGE = 14;

	private const CRAFT = 4;

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
		return self::createCastle(Stronghold::CLASS);
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}

	#[Pure] protected function constructionLevel(): int {
		return self::CRAFT;
	}
}
