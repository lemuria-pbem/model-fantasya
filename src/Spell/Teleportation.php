<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class Teleportation extends AbstractSpell
{
	private const AURA = 1;

	private const DIFFICULTY = 7;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
