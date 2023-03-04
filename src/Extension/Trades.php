<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Extension;

use Lemuria\EntitySet;
use Lemuria\Exception\LemuriaException;
use Lemuria\Id;
use Lemuria\Model\Fantasya\Extension;
use Lemuria\Model\Fantasya\Factory\BuilderTrait;
use Lemuria\Model\Fantasya\Market\Trade;
use Lemuria\Model\Fantasya\Sorting\Trade\ByDeal;
use Lemuria\Sorting\ById;
use Lemuria\SortMode;

/**
 * Trades of a unit are offers and demands on the market.
 *
 * @method Trade offsetGet(int|Id $offset)
 * @method Trade current()
 */
class Trades extends EntitySet implements Extension
{
	use BuilderTrait;
	use ExtensionTrait;

	public function getClone(): Trades {
		return clone $this;
	}

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

	/**
	 * Sort the constructions.
	 */
	public function sort(SortMode $mode = SortMode::ByType): Trades {
		switch ($mode) {
			case SortMode::ById :
				$this->sortUsing(new ById());
				break;
			case SortMode::ByType :
				$this->sortUsing(new ByDeal());
				break;
			default :
				throw new LemuriaException('Unsupported sort mode: ' . $mode->name);
		}
		return $this;
	}

	protected function get(Id $id): Trade {
		return Trade::get($id);
	}
}
