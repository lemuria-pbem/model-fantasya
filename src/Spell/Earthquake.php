<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Earthquake extends AbstractSpell
{
	private const int AURA = 25;

	private const int DIFFICULTY = 9;

	private const int ORDER = 0;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Order(): int {
		return self::ORDER;
	}
}
