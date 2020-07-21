<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Exception;

use Lemuria\Model\Lemuria\LemuriaMessage;

class EntityNotSetException extends \UnexpectedValueException
{
	/**
	 * @param LemuriaMessage $message
	 * @param string $name
	 */
	public function __construct(LemuriaMessage $message, string $name) {
		parent::__construct('Message ' . $message->Id() . ' has no entity ' . $name . '.');
	}
}
