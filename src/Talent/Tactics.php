<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

/**
 * The Tactics talent.
 */
final class Tactics extends AbstractTalent
{
	public function getExpense(int $level): int {
		return 100;
	}
}
