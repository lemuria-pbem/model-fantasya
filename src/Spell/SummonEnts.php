<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class SummonEnts extends AbstractSpell
{
	private const int AURA = 3;

	private const int DIFFICULTY = 3;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
