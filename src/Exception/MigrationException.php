<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

class MigrationException extends \RuntimeException
{
	public function __construct(string $message = '', int $code = 0, ?\Throwable $previous = null) {
		if (!$message) {
			$message = 'Migration not possible.';
		}
		parent::__construct($message, $code, $previous);
	}
}
