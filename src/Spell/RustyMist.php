<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\Combat\Phase;

final class RustyMist extends AbstractBattleSpell
{
	private const int AURA = 3;

	private const int DIFFICULTY = 6;

	public function Aura(): int {
		return self::AURA;
	}

	public function Difficulty(): int {
		return self::DIFFICULTY;
	}

	public function Phase(): Phase {
		return Phase::Preparation;
	}
}
