<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

interface BattleSpell extends Spell
{
	public const PREPARATION = 0;

	public const COMBAT = 1;

	/**
	 * Get the phase of battle when the spell is cast.
	 */
	public function Phase(): int;
}
