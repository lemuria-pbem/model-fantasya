<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\Combat\Phase;

final class StoneSkin extends AbstractBattleSpell
{
	private const AURA = 1;

	private const DIFFICULTY = 8;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Phase(): Phase {
		return Phase::PREPARATION;
	}
}
