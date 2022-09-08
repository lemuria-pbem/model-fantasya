<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\EntitySet;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Market\Trade;

/**
 * Trades of a unit are offers and demands on the market.
 *
 * @\ArrayAccess<int|Id, Trade>
 * @\Iterator<int, Trade>
 */
class Trades extends EntitySet implements Extension
{
	use BuilderTrait;
	use ExtensionTrait;

	public function add(Trade $trade): self {
		$this->addEntity($trade->Id());
		if ($this->hasCollector()) {
			$trade->addCollector($this->collector());
		}
		return $this;
	}

	public function remove(Trade $trade): self {
		$this->removeEntity($trade->Id());
		return $this;
	}

	protected function get(Id $id): Trade {
		return Trade::get($id);
	}
}
