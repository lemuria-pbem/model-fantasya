<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria\Exception;

use Lemuria\Model\Exception\ModelException;
use Lemuria\Model\Message;

class DuplicateMessageException extends ModelException
{
	/**
	 * @param Message $message
	 */
	public function __construct(Message $message) {
		parent::__construct('Report message ' . $message->Id() . ' is already registered.');
	}
}
