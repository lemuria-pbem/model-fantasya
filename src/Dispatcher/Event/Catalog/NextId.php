<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Dispatcher\Event\Catalog;

use Lemuria\Model\Fantasya\Dispatcher\Event;

final readonly class NextId extends Event
{
	public function __construct(public int $domain, public int $id) {
		parent::__construct();
	}
}
