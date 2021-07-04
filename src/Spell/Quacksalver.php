<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Quacksalver extends AbstractSpell
{
	private const AURA = 1;

	private const DIFFICULTY = 1;

	private const ORDER = 2;

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
