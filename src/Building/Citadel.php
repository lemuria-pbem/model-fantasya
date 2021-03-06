<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use JetBrains\PhpStorm\Pure;

/**
 * The last level of a castle.
 */
final class Citadel extends AbstractCastle
{
	private const DEFENSE = 4;

	private const MAX_SIZE = PHP_INT_MAX;

	private const MIN_SIZE = 1250;

	private const TALENT = 6;

	private const WAGE = 16;

	private const CRAFT = 6;

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
		return self::createCastle(Stronghold::class);
	}

	public function Upgrade(): Castle {
		return $this;
	}

	#[Pure] public function Wage(): int {
		return self::WAGE;
	}

	#[Pure] protected function constructionLevel(): int {
		return self::CRAFT;
	}
}
