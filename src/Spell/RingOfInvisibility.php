<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class RingOfInvisibility extends AbstractSpell
{
	private const AURA = 32;

	private const DIFFICULTY = 8;

	protected bool $isIncremental = false;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}