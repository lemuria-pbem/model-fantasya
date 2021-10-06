<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The third level of a castle.
 */
final class Tower extends AbstractCastle
{
	private const TALENT = 3;

	private const WAGE = 13;

	private const DEFENSE = 1;

	private const MIN_SIZE = 10;

	public const MAX_SIZE = 49;

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

	public function Downgrade(): Castle {
		return self::createCastle(Fort::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Palace::class);
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}
}
