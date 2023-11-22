<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The third level of a castle.
 */
final class Tower extends AbstractCastle
{
	private const int TALENT = 3;

	private const int DEFENSE = 1;

	private const int MIN_SIZE = 10;

	public final const int MAX_SIZE = 49;

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
		return self::createCastle(Fort::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Palace::class);
	}
}
