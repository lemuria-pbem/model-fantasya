<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Market;

use Lemuria\Model\Fantasya\Construction;
use Lemuria\Model\Fantasya\Exception\SalesException;
use Lemuria\Model\Fantasya\Extension\Market;
use Lemuria\Model\Fantasya\Extension\Trades;
use Lemuria\Model\Fantasya\Unit;

/**
 * Sales are all trades of all merchants on a market that are allowed and can be delivered.
 */
class Sales implements \Countable
{
	public final const int AVAILABLE = 0;

	public final const int FORBIDDEN = 1;

	public final const int UNSATISFIABLE = 2;

	protected Tradeables $tradeables;

	protected Trades $trades;

	/**
	 * @var array<int, int>
	 */
	protected array $notTradeable = [];

	public function __construct(protected Construction $construction) {
		$extensions = $construction->Extensions();
		if (!$extensions->offsetExists(Market::class)) {
			throw new SalesException('Construction ' . $construction . ' has no market.');
		}
		/** @var Market $market */
		$market           = $extensions[Market::class];
		$this->tradeables = $market->Tradeables();
		$this->trades     = new Trades();

		foreach ($construction->Inhabitants() as $unit) {
			$this->addTrades($unit);
		}
	}

	public function count(): int {
		return $this->trades->count();
	}

	public function has(Trade $trade): bool {
		$id = $trade->Id();
		return isset($this->notTradeable[$id->Id()]) || $this->trades->has($id);
	}

	public function getStatus(Trade $trade): int {
		$id = $trade->Id();
		$i  = $id->Id();
		if (isset($this->notTradeable[$i])) {
			return $this->notTradeable[$i];
		}
		if ($this->trades->has($id)) {
			return self::AVAILABLE;
		}
		throw new SalesException('Unknown trade ' . $trade);
	}

	protected function addTrades(Unit $unit): void {
		$extensions = $unit->Extensions();
		if ($extensions->offsetExists(Trades::class)) {
			/** @var Trades $trades */
			$trades = $extensions[Trades::class];
			foreach ($trades as $trade) {
				$goods     = $trade->Goods();
				$commodity = $goods->Commodity();
				if (!$this->tradeables->isAllowed($commodity)) {
					$this->notTradeable[$trade->Id()->Id()] = self::FORBIDDEN;
					continue;
				}

				$price   = $trade->Price();
				$payment = $price->Commodity();
				if (!$this->tradeables->isAllowed($payment)) {
					$this->notTradeable[$trade->Id()->Id()] = self::FORBIDDEN;
					continue;
				}

				if ($trade->IsSatisfiable()) {
					$this->trades->add($trade);
				} else {
					$this->notTradeable[$trade->Id()->Id()] = self::UNSATISFIABLE;
				}
			}
		}
	}
}
