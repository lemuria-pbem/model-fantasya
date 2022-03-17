<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Earthquake extends AbstractSpell
{
	private const AURA = 25;

	private const DIFFICULTY = 9;

	private const ORDER = 0;

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
