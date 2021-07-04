<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

/**
 * The Espionage talent.
 */
final class Espionage extends AbstractTalent
{
	public function getExpense(int $level): int {
		return 150;
	}
}
