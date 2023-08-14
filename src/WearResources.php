<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Exception\ItemSetFillException;
use Lemuria\Exception\LemuriaException;
use Lemuria\ItemSet;
use Lemuria\Model\Fantasya\Factory\RepairableCatalog;

/**
 * A resource helper class that transforms some part of its items into repairables.
 */
class WearResources extends Resources
{
	protected float $probability;

	protected RepairableCatalog $catalog;

	public function __construct() {
		$this->catalog = new RepairableCatalog();
	}

	/**
	 * When filling, transform some items into repairables.
	 */
	public function fill(ItemSet $set): static {
		foreach ($set as $item) {
			if ($item instanceof Quantity) {
				$this->addWorn($item);
			} else {
				if (!$this->isValidItem($item)) {
					throw new ItemSetFillException($item, $this);
				}
				$this->addItem($item);
			}
		}
		return $this;
	}

	public function setWear(float $probability): static {
		if ($probability < 0.0 || $probability > 1.0) {
			throw new LemuriaException('Wear probability must be in interval [0.0; 1.0].');
		}
		$this->probability = $probability;
		return $this;
	}

	protected function addWorn(Quantity $quantity): void {
		$commodity = $quantity->Commodity();
		if (!($commodity instanceof Repairable)) {
			$count     = $quantity->Count();
			$wearCount = (int)floor($this->probability * $count);
			if ($wearCount > 0) {
				$repairable = $this->catalog->getRepairable($commodity);
				if ($repairable instanceof Commodity) {
					$count -= $wearCount;
					if ($count > 0) {
						$this->addItem(new Quantity($commodity, $count));
					}
					$this->addItem(new Quantity($repairable, $wearCount));
					return;
				}
			}
		}
		$this->addItem($quantity);
	}
}
