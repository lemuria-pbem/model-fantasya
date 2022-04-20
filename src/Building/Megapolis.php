<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The last level of a castle.
 */
final class Megapolis extends AbstractCastle
{
	private const TALENT = 15;

	private const WAGE = 18;

	private const DEFENSE = 5;

	private const MIN_SIZE = 31250;

	public final const MAX_SIZE = PHP_INT_MAX;

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
		return self::createCastle(Acropolis::class);
	}

	public function Upgrade(): Castle {
		return $this;
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}
}
