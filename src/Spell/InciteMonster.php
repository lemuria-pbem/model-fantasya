<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class InciteMonster extends AbstractSpell
{
	private const AURA = 2;

	private const DIFFICULTY = 2;

	protected bool $isIncremental = false;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
