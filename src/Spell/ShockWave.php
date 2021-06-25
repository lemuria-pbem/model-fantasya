<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\BattleSpell;

final class ShockWave extends AbstractSpell implements BattleSpell
{
	private const AURA = 1;

	private const DIFFICULTY = 5;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Phase(): int {
		return BattleSpell::COMBAT;
	}
}
