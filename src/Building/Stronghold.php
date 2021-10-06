<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The fifth level of a castle.
 */
final class Stronghold extends AbstractCastle
{
	public const MAX_SIZE = 1249;

	private const DEFENSE = 3;

	private const MIN_SIZE = 250;

	private const TALENT = 5;

	private const WAGE = 15;

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
		return self::createCastle(Palace::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Citadel::class);
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}
}
