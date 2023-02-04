<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Location;

/**
 * This exception is thrown by the Census class.
 */
class CensusException extends \InvalidArgumentException
{
	/**
	 * Create an exception for a Region that is not in a Census.
	 */
	public function __construct(Location $location, Party $party) {
		$message = 'The region ' . $location->Id() . ' is not in the census of party ' . $party->Id() . '.';
		parent::__construct($message);
	}
}
