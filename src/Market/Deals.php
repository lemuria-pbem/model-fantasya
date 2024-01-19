<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Model\Fantasya\Extension\Trades;
use Lemuria\Model\Fantasya\Unit;

/**
 * Deals are all trades of a merchant that can be delivered.
 */
class Deals implements \Countable
{
	protected Trades $trades;

	protected Trades $unsatisfiable;

	public function __construct(Unit $unit) {
		$this->trades        = new Trades();
		$this->unsatisfiable = new Trades();
		$this->addTrades($unit);
	}

	public function Trades(): Trades {
		return $this->trades;
	}

	public function Unsatisfiable(): Trades {
		return $this->unsatisfiable;
	}

	public function count(): int {
		return $this->trades->count() + $this->unsatisfiable->count();
	}

	protected function addTrades(Unit $unit): void {
		$extensions = $unit->Extensions();
		if ($extensions->offsetExists(Trades::class)) {
			/** @var Trades $trades */
			$trades = $extensions[Trades::class];
			foreach ($trades as $trade) {
				if ($trade->IsSatisfiable()) {
					$this->trades->add($trade);
				} else {
					$this->unsatisfiable->add($trade);
				}
			}
		}
	}
}
