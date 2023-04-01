<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Model\Fantasya\Distribution;
use Lemuria\Model\Fantasya\Quantity;
use Lemuria\Model\Fantasya\Unit;

class InventoryDistribution
{
	/**
	 * @var array<Distribution>
	 */
	protected array $distributions;

	public function __construct(protected readonly Unit $unit) {
	}

	/**
	 * @return array<Distribution>
	 */
	public function get(): array {
		return $this->distributions;
	}

	public function distribute(): InventoryDistribution {
		$maxSize   = $this->unit->Size();
		$inventory = $this->unit->Inventory();
		if ($maxSize <= 1 || $inventory->isEmpty()) {
			$distribution = new Distribution();
			foreach ($inventory as $quantity) {
				$distribution->add(new Quantity($quantity->Commodity(), $quantity->Count()));
			}
			$this->distributions = [$distribution->setSize($maxSize)];
		}

		$amount = [];
		foreach ($inventory as $quantity) {
			$count = $quantity->Count();
			if (!isset($amount[$count])) {
				$amount[$count] = [];
			}
			$amount[$count][] = new Quantity($quantity->Commodity(), $count);
		}
		ksort($amount);

		$this->distributions = [];
		while ($maxSize > 0 && !empty($amount)) {
			reset($amount);
			$size         = key($amount);
			$take         = $size > $maxSize ? (int)floor($size / $maxSize) : 1;
			$rest         = $size - $take * $maxSize;
			$distribution = new Distribution();
			$newAmount    = $rest > 0 ? [$rest => []] : [];
			foreach (current($amount) as $quantity /** @var Quantity $quantity */) {
				$commodity = $quantity->Commodity();
				if ($rest > 0) {
					$newAmount[$rest][] = new Quantity($commodity, $rest);
				}
				$distribution->add(new Quantity($commodity, $take));
			}
			unset($amount[$size]);
			if ($rest > 0) {
				$size = $maxSize;
			}

			foreach ($amount as $next => $quantities) {
				$take = $next > $maxSize ? (int)floor($next / $maxSize) : 1;
				$rest = $next - $take * $size;
				if ($rest > 0 && !isset($newAmount[$rest])) {
					$newAmount[$rest] = [];
				}
				foreach ($quantities as $quantity /** @var Quantity $quantity */) {
					$commodity = $quantity->Commodity();
					if ($rest > 0) {
						$newAmount[$rest][] = new Quantity($commodity, $rest);
					}
					$distribution->add(new Quantity($commodity, $take));
				}
			}

			$size                  = min($maxSize, $size);
			$this->distributions[] = $distribution->setSize($size);
			$maxSize              -= $size;
			$amount                = $newAmount;
		}

		if ($maxSize > 0) {
			$distribution          = new Distribution();
			$this->distributions[] = $distribution->setSize($maxSize);
		}

		return $this;
	}
}
