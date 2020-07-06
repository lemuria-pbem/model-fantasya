<?php
declare (strict_types = 1);
namespace Lemuria\Model\Lemuria\Landscape;

use Lemuria\Model\Lemuria\Landscape;
use Lemuria\SingletonTrait;

/**
 * Base class for all landscapes.
 */
abstract class AbstractLandscape implements Landscape
{
	use SingletonTrait;
}
