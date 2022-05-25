<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Engine\Message;
use Lemuria\Model\Domain;

interface MessageType
{
	/**
	 * Get the report type of this message.
	 */
	
	public function Report(): Domain;

	/**
	 * Build the message.
	 */
	public function render(Message $message): string;
}
