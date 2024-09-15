<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Dispatcher;

use Lemuria\Dispatcher\AbstractEvent;

abstract readonly class Event extends AbstractEvent
{
	public string $family;

	public function __construct() {
		$this->family = self::class;
	}
}
