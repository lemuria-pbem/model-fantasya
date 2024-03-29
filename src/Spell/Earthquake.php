<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Earthquake extends AbstractSpell
{
	private const int AURA = 25;

	private const int DIFFICULTY = 9;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
