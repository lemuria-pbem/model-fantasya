<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya\Factory;

use Lemuria\Model\Fantasya\Commodity;
use Lemuria\Model\Fantasya\Distribution;
use Lemuria\Model\Fantasya\Exception\EmptyUnitException;
use Lemuria\Model\Fantasya\Quantity;
use Lemuria\Model\Fantasya\Resources;
use Lemuria\Model\Fantasya\Unit;

class InventoryDistribution
{
	/**
	 * @var array<Distribution>
	 */
	protected array $distributions;

	protected Resources $inventory;

	public function __construct(protected readonly Unit $unit) {
	}

	public function distribute(): InventoryDistribution {
		$this->createDistributions();
		$this->cloneInventory();
		$this->distributeInventory();
		return $this;
	}

	/**
	 * @return array<Distribution>
	 */
	public function getDistributions(): array {
		return $this->distributions;
	}

	protected function createDistributions(): void {
		$size = $this->unit->Size();
		if ($size <= 0) {
			throw new EmptyUnitException($this->unit);
		}
		$distribution        = new Distribution();
		$this->distributions = [$distribution->setSize($size)];
	}

	protected function cloneInventory(): void {
		$this->inventory = new Resources();
		foreach ($this->unit->Inventory() as $quantity) {
			$this->inventory->add(new Quantity($quantity->Commodity(), $quantity->Count()));
		}
	}

	protected function distributeInventory(): void {
		$size = $this->unit->Size();
		foreach ($this->inventory as $quantity) {
			$total   = $quantity->Count();
			$portion = (int)floor($total / $size);
			$this->giveToEverybody($quantity->Commodity(), $portion);
			$rest = $total % $size;
			$this->giveOnlyOne($quantity->Commodity(), $rest);
		}
	}

	private function giveToEverybody(Commodity $commodity, int $count): void {
		if ($count > 0) {
			foreach ($this->distributions as $distribution) {
				$distribution->add(new Quantity($commodity, $count));
			}
		}
	}

	private function giveOnlyOne(Commodity $commodity, int $amount): void {
		$i = 0;
		while ($amount > 0) {
			$distribution = $this->distributions[$i++];
			$size         = $distribution->Size();
			if ($amount < $size) {
				$newDistribution = $this->splitNewDistribution($distribution, $amount);
				$this->insertNewDistribution($newDistribution, $i);
				$distribution->add(new Quantity($commodity, 1));
				break;
			}
			$distribution->add(new Quantity($commodity, 1));
			$amount -= $size;
		}
	}

	private function splitNewDistribution(Distribution $distribution, int $keepSize): Distribution {
		$newDistribution = new Distribution();
		$newSize         = $distribution->Size() - $keepSize;
		$distribution->setSize($keepSize);
		$newDistribution->setSize($newSize);
		foreach ($distribution as $quantity) {
			$newDistribution->add(new Quantity($quantity->Commodity(), $quantity->Count()));
		}
		return $newDistribution;
	}

	private function insertNewDistribution(Distribution $newDistribution, int $index): void {
		if ($index < count($this->distributions)) {
			$rest                = array_splice($this->distributions, $index);
			$this->distributions = array_merge($this->distributions, [$newDistribution], $rest);
		} else {
			$this->distributions[] = $newDistribution;
		}
	}
}
