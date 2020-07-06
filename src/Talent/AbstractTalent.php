<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Talent;

use Lemuria\Model\Lemuria\Talent;
use Lemuria\SingletonTrait;

/**
 * The Archery talent.
 */
abstract class AbstractTalent implements Talent
{
	use SingletonTrait;
}
