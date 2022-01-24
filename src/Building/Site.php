<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The first level of a castle.
 */
final class Site extends AbstractCastle
{
	private const TALENT = 1;

	private const WAGE = 11;

	private const DEFENSE = 0;

	private const MIN_SIZE = 0;

	public final const MAX_SIZE = 1;

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
		return $this;
	}

	public function Upgrade(): Castle {
		return self::createCastle(Fort::class);
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}
}
