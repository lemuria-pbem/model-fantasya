<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class CivilCommotion extends AbstractSpell
{
	private const AURA = 4;

	private const DIFFICULTY = 2;

	protected bool $isIncremental = false;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}