<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use Lemuria\Model\Exception\ModelException;

class WorldMapException extends ModelException
{
	public function __construct() {
		parent::__construct('This world has no Map features.');
	}
}
