<?php
declare(strict_types = 1);
namespace Lemuria\Model\Lemuria;

use JetBrains\PhpStorm\ExpectedValues;
use JetBrains\PhpStorm\Pure;

use Lemuria\Engine\Message;
use Lemuria\Engine\Report;

interface MessageType
{
	/**
	 * Get the report type of this message.
	 */
	#[ExpectedValues(valuesFromClass: Report::class)]
	#[Pure]
	public function Report(): int;

	/**
	 * Build the message.
	 */
	public function render(Message $message): string;
}
