<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

/**
 * The Herbal Lore talent.
 */
final class Herballore extends AbstractTalent
{
	public const int EXPLORE_LEVEL = 3;

	public function getExpense(int $level): int {
		return 100;
	}
}
