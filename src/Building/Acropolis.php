<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The seventh level of a castle.
 */
final class Acropolis extends AbstractCastle
{
	private const TALENT = 10;

	private const WAGE = 17;

	private const DEFENSE = 5;

	private const MIN_SIZE = 6250;

	public final const MAX_SIZE = 31249;

	public function Defense(): int {
		return self::DEFENSE;
	}

	public function MaxSize(): int {
		return self::MAX_SIZE;
	}

	public function MinSize(): int {
		return self::MIN_SIZE;
	}

	public function Talent(): int {
		return self::TALENT;
	}

	public function Downgrade(): Castle {
		return self::createCastle(Citadel::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Megapolis::class);
	}

	public function Wage(): int {
		return self::WAGE;
	}
}
