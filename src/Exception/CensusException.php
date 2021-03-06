<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Party;
use Lemuria\Model\Fantasya\Region;

/**
 * This exception is thrown by the Census class.
 */
class CensusException extends \InvalidArgumentException
{
	/**
	 * Create an exception for a Region that is not in a Census.
	 */
	#[Pure] public function __construct(Region $region, Party $party) {
		$message = 'The region ' . $region->Id() . ' is not in the census of party ' . $party->Id() . '.';
		parent::__construct($message);
	}
}
