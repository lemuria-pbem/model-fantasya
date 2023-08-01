<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

/**
 * The fifth level of a castle.
 */
final class Stronghold extends AbstractCastle
{
	private const TALENT = 5;

	private const DEFENSE = 3;

	private const MIN_SIZE = 250;

	public final const MAX_SIZE = 1249;

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
		return self::createCastle(Palace::class);
	}

	public function Upgrade(): Castle {
		return self::createCastle(Citadel::class);
	}
}
