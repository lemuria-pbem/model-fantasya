<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

/**
 * The Alchemy talent.
 */
final class Alchemy extends AbstractTalent
{
	public function getExpense(int $level): int {
		return 100;
	}
}
