<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class RestInPeace extends AbstractSpell
{
	private const int AURA = 8;

	private const int DIFFICULTY = 4;

	protected bool $isIncremental = false;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
