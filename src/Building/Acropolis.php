<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The seventh level of a castle.
 */
final class Acropolis extends AbstractCastle
{
	private const int TALENT = 10;

	private const int DEFENSE = 5;

	private const int MIN_SIZE = 6250;

	public final const int MAX_SIZE = 31249;

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
}
