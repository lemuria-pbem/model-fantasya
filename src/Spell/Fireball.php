<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Fireball extends AbstractBattleSpell
{
	private const AURA = 1;

	private const DIFFICULTY = 3;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
