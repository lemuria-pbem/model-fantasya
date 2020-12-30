<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Exception;

use Lemuria\Engine\Message;

class EntityNotSetException extends \UnexpectedValueException
{
	public function __construct(Message $message, string $name) {
		parent::__construct('Message ' . $message->Id() . ' has no entity ' . $name . '.');
	}
}
