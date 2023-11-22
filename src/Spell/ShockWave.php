<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class ShockWave extends AbstractBattleSpell
{
	private const int AURA = 1;

	private const int DIFFICULTY = 5;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
