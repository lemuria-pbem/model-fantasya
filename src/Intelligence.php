<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya;

use Lemuria\Model\Fantasya\Building\Castle;
use Lemuria\Model\Fantasya\Party\Type;
use Lemuria\Model\World\Direction;

/**
 * Helper class for region information.
 */
final readonly class Intelligence
{
	public function __construct(private Region $region) {
	}

	public function Region(): Region {
		return $this->region;
	}

	/**
	 * Get the parties that are currently represented in the region.
	 */
	public function getParties(): Gathering {
		$parties = new Gathering();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			$parties->add($unit->Party());
		}
		return $parties;
	}

	/**
	 * Get the units of a party that are in the region.
	 */
	public function getUnits(Party $party): People {
		$units = new People();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			if ($unit->Party() === $party) {
				$units->add($unit);
			}
		}
		return $units;
	}

	/**
	 * Get the guards of the region.
	 */
	public function getGuards(): People {
		$guards = new People();
		foreach ($this->region->Residents() as $unit /* @var Unit $unit */) {
			if ($unit->IsGuarding()) {
				$guards->add($unit);
			}
		}
		return $guards;
	}

	/**
	 * Get the units of a region that can be possible heirs of a unit.
	 */
	public function getHeirs(Unit $unit, bool $sameParty = true): Heirs {
		$heirs = new Heirs($unit);
		$party = $unit->Party();
		if ($sameParty) {
			foreach ($this->getUnits($party) as $otherUnit) {
				if ($otherUnit->IsLooting() && $otherUnit->Size() > 0) {
					$heirs->add($otherUnit);
				}
			}
		} else {
			foreach ($this->region->Residents() as $otherUnit) {
				$otherParty = $otherUnit->Party();
				if ($otherParty !== $party && $otherParty->Type() === Type::Player) {
					if ($otherUnit->IsLooting() && $otherUnit->Size() > 0) {
						$heirs->add($otherUnit);
					}
				}
			}
		}
		return $heirs;
	}

	/**
	 * Get the units of a region that are interested in a specific loot.
	 */
	public function getLooters(Unit $unit, Commodity $loot): Heirs {
		$heirs = new Heirs($unit);
		$party = $unit->Party();
		foreach ($this->region->Residents() as $otherUnit) {
			$otherParty = $otherUnit->Party();
			if ($otherParty !== $party && $otherParty->Type() === Type::Player) {
				if ($otherUnit->IsLooting() && $otherUnit->Size() > 0) {
					if ($otherParty->Loot()->wants($loot)) {
						$heirs->add($otherUnit);
					}
				}
			}
		}
		return $heirs;
	}

	/**
	 * Get the biggest castle in that region.
	 */
	public function getCastle(): ?Construction {
		$castle  = null;
		$biggest = 0;
		foreach ($this->region->Estate() as $construction /* @var Construction $construction */) {
			if ($construction->Building() instanceof Castle) {
				$size = $construction->Size();
				if ($size > $biggest) {
					$castle  = $construction;
					$biggest = $size;
				}
			}
		}
		return $castle;
	}

	/**
	 * Get the government of a region, which is the biggest castle in that region that is inhabited.
	 */
	public function getGovernment(): ?Construction {
		$castle  = null;
		$biggest = 0;
		foreach ($this->region->Estate() as $construction /* @var Construction $construction */) {
			if ($construction->Building() instanceof Castle) {
				$size = $construction->Size();
				if ($size > $biggest && !$construction->Inhabitants()->isEmpty()) {
					$castle  = $construction;
					$biggest = $size;
				}
			}
		}
		return $castle;
	}

	/**
	 * Get the infrastructure of the region.
	 */
	public function getInfrastructure(): int {
		$infrastructure = 0;
		foreach ($this->region->Estate() as $construction) {
			$infrastructure += $construction->StructurePoints();
		}
		$roads = $this->region->Roads();
		if ($roads) {
			$stones = $this->region->Landscape()->RoadStones();
			foreach (Direction::cases() as $direction) {
				$completion      = $roads[$direction] ?? 0.0;
				$infrastructure += (int)round($completion * $stones);
			}
		}
		return $infrastructure;
	}

	/**
	 * Get the material pool of a party in the region.
	 */
	public function getMaterialPool(Party $party): Resources {
		$pool = new Resources();
		foreach ($this->getUnits($party) as $unit /* @var Unit $unit*/) {
			foreach ($unit->Inventory() as $item /* @var Quantity $item */) {
				$pool->add(new Quantity($item->Commodity(), $item->Count()));
			}
		}
		return $pool;
	}
}
