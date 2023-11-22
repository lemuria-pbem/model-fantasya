<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The first level of a castle.
 */
final class Site extends AbstractCastle
{
	private const int TALENT = 1;

	private const int DEFENSE = 0;

	private const int MIN_SIZE = 0;

	public final const int MAX_SIZE = 1;

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
		return $this;
	}

	public function Upgrade(): Castle {
		return self::createCastle(Fort::class);
	}
}
