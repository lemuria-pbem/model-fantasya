<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Talent;

use Lemuria\Model\Fantasya\Talent;
use Lemuria\SingletonTrait;

/**
 * The Archery talent.
 */
abstract class AbstractTalent implements Talent
{
	use SingletonTrait;

	public function getExpense(int $level): int {
		return 0;
	}
}
