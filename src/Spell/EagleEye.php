<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class EagleEye extends AbstractSpell
{
	private const int AURA = 1;

	private const int DIFFICULTY = 1;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}
}
