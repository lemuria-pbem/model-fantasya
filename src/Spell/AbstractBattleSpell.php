<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Spell;

use Lemuria\Model\Fantasya\BattleSpell;

abstract class AbstractBattleSpell extends AbstractSpell implements BattleSpell
{
	public function Order(): int {
		return 3;
	}

	public function Phase(): int {
		return BattleSpell::COMBAT;
	}
}
