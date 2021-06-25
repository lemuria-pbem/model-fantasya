<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

final class AuraTransfer extends AbstractSpell
{
	private const AURA = 2;

	private const DIFFICULTY = 4;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Order(): int {
		return 0;
	}
}
