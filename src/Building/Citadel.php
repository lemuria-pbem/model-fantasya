<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The sixth level of a castle.
 */
final class Citadel extends AbstractCastle
{
	private const TALENT = 7;

	private const DEFENSE = 4;

	private const MIN_SIZE = 1250;

	public final const MAX_SIZE = 6249;

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
		return self::createCastle(Stronghold::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Acropolis::class);
	}
}
