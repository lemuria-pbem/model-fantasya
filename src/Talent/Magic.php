<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

/**
 * The Magic talent.
 */
final class Magic extends AbstractTalent
{
	public function getExpense(int $level): int {
		return 100 + $level * 150;
	}
}
