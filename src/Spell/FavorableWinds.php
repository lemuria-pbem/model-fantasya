<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class FavorableWinds extends AbstractSpell
{
	public const SPEED_BONUS = 2;

	private const AURA = 25;

	private const DIFFICULTY = 5;

	protected bool $isIncremental = false;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
