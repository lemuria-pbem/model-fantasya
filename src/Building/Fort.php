<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The second level of a castle.
 */
final class Fort extends AbstractCastle
{
	private const int TALENT = 2;

	private const int DEFENSE = 0;

	private const int MIN_SIZE = 2;

	public final const int MAX_SIZE = 9;

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
		return self::createCastle(Site::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Tower::class);
	}
}
