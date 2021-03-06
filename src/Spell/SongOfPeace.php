<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\BattleSpell;

final class SongOfPeace extends AbstractBattleSpell
{
	private const AURA = 2;

	private const DIFFICULTY = 2;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Phase(): int {
		return BattleSpell::PREPARATION;
	}
}
