<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Exception;

use Lemuria\Model\Fantasya\Extension;

class ExtensionNotFoundException extends \OutOfBoundsException
{
	public function __construct(Extension|string $extension, ?\Throwable $previous = null) {
		$message = 'Extension ' . $extension . ' has not been set.';
		parent::__construct($message, previous: $previous);
	}
}
