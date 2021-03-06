<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Landscape;

use Lemuria\Model\Fantasya\Landscape;
use Lemuria\SingletonTrait;

/**
 * Base class for all landscapes.
 */
abstract class AbstractLandscape implements Landscape
{
	use SingletonTrait;
}
