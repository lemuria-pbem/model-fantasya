<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\Combat\Phase;

final class SongOfPeace extends AbstractBattleSpell
{
	private const int AURA = 1;

	private const int DIFFICULTY = 2;

	protected bool $isIncremental = false;

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
