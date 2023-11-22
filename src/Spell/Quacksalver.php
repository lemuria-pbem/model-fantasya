<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Quacksalver extends AbstractSpell
{
	private const int AURA = 1;

	private const int DIFFICULTY = 1;

	private const int ORDER = 2;

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
