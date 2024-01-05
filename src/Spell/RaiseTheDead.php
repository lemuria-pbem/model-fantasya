<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class RaiseTheDead extends AbstractSpell
{
	private const int AURA = 5;

	private const int DIFFICULTY = 5;

	private const int ORDER = 3;

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
