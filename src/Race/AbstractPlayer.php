<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Race;

use Lemuria\Model\Fantasya\Raiseable;
use Lemuria\Model\Fantasya\UndeadTrait;

/**
 * Base class for all player races.
 */
abstract class AbstractPlayer extends AbstractRace implements Raiseable
{
	use UndeadTrait;
}
