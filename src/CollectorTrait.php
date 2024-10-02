<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Dispatcher\AbstractEvent;
use Lemuria\Dispatcher\Event\Catalog\Loaded;

trait CollectorTrait
{
	public function getCollectAllEvent(): AbstractEvent {
		return new Loaded();
	}
}
