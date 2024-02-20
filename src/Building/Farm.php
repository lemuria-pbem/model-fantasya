<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Building;

use Lemuria\Model\Fantasya\Building;
use Lemuria\SingletonSet;

/**
 * A farm is a workplace building for a specific landscape.
 */
interface Farm extends Building
{
	public function Landscapes(): SingletonSet;
}
