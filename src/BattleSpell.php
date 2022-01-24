<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Combat\Phase;

interface BattleSpell extends Spell
{
	/**
	 * Get the phase of battle when the spell is cast.
	 */
	public function Phase(): Phase;
}
