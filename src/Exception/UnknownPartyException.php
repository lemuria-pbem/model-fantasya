<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Diplomacy;
use Lemuria\Model\Fantasya\Party;

/**
 * This exception is thrown by the Diplomacy class.
 */
class UnknownPartyException extends \InvalidArgumentException
{
	#[Pure] public function __construct(Diplomacy $diplomacy, Party $party) {
		$message = 'The party ' . $party->Id() . ' is unknown to the party ' . $diplomacy->Party()->Id() . '.';
		parent::__construct($message);
	}
}
