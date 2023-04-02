<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use Lemuria\Model\Fantasya\Unit;

/**
 * This exception is thrown when the size of a unit is zero.
 */
class EmptyUnitException extends \InvalidArgumentException
{
	public function __construct(Unit $unit) {
		$message = 'The unit ' . $unit->Id() . ' is empty, a size of at least one is required.';
		parent::__construct($message);
	}
}
