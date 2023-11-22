<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class AuraTransfer extends AbstractSpell
{
	private const int AURA = 2;

	private const int DIFFICULTY = 4;

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
