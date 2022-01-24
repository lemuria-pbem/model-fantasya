<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

class Heirs
{
	protected readonly People $inConstruction;

	protected readonly People $onVessel;

	protected readonly People $outside;

	protected readonly People $otherConstruction;

	protected readonly People $otherVessel;

	protected ?Construction $construction = null;

	protected ?Vessel $vessel = null;

	public function __construct(protected Unit $unit) {
		$this->inConstruction    = new People();
		$this->onVessel          = new People();
		$this->outside           = new People();
		$this->otherConstruction = new People();
		$this->otherVessel       = new People();
		$this->construction      = $unit->Construction();
		$this->vessel            = $unit->Vessel();
	}

	public function add(Unit $unit): Heirs {
		$construction = $unit->Construction();
		if ($construction) {
			if ($construction === $this->construction) {
				$this->inConstruction->add($unit);
			} else {
				$this->otherConstruction->add($unit);
			}
		} else {
			$vessel = $unit->Vessel();
			if ($vessel) {
				if ($vessel === $this->vessel) {
					$this->onVessel->add($unit);
				} else {
					$this->otherVessel->add($unit);
				}
			} else {
				$this->outside->add($unit);
			}
		}
		return $this;
	}

	public function get(): ?Unit {
		if ($this->construction) {
			if ($this->inConstruction->count() > 0) {
				return $this->getFirst($this->inConstruction);
			}
			if ($this->outside->count() > 0) {
				return $this->getFirst($this->outside);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getFirst($this->otherConstruction);
			}
			if ($this->onVessel->count() > 0) {
				return $this->getFirst($this->onVessel);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getFirst($this->otherVessel);
			}
		} elseif ($this->vessel) {
			if ($this->onVessel->count() > 0) {
				return $this->getFirst($this->onVessel);
			}
			if ($this->outside->count() > 0) {
				return $this->getFirst($this->outside);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getFirst($this->otherVessel);
			}
			if ($this->inConstruction->count() > 0) {
				return $this->getFirst($this->inConstruction);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getFirst($this->otherConstruction);
			}
		} else {
			if ($this->outside->count() > 0) {
				return $this->getFirst($this->outside);
			}
			if ($this->inConstruction->count() > 0) {
				return $this->getFirst($this->inConstruction);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getFirst($this->otherConstruction);
			}
			if ($this->onVessel->count() > 0) {
				return $this->getFirst($this->onVessel);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getFirst($this->otherVessel);
			}
		}
		return null;
	}

	public function random(): ?Unit {
		if ($this->construction) {
			if ($this->inConstruction->count() > 0) {
				return $this->getRandom($this->inConstruction);
			}
			if ($this->outside->count() > 0) {
				return $this->getRandom($this->outside);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getRandom($this->otherConstruction);
			}
			if ($this->onVessel->count() > 0) {
				return $this->getRandom($this->onVessel);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getRandom($this->otherVessel);
			}
		} elseif ($this->vessel) {
			if ($this->onVessel->count() > 0) {
				return $this->getRandom($this->onVessel);
			}
			if ($this->outside->count() > 0) {
				return $this->getRandom($this->outside);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getRandom($this->otherVessel);
			}
			if ($this->inConstruction->count() > 0) {
				return $this->getRandom($this->inConstruction);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getRandom($this->otherConstruction);
			}
		} else {
			if ($this->outside->count() > 0) {
				return $this->getRandom($this->outside);
			}
			if ($this->inConstruction->count() > 0) {
				return $this->getRandom($this->inConstruction);
			}
			if ($this->otherConstruction->count() > 0) {
				return $this->getRandom($this->otherConstruction);
			}
			if ($this->onVessel->count() > 0) {
				return $this->getRandom($this->onVessel);
			}
			if ($this->otherVessel->count() > 0) {
				return $this->getRandom($this->otherVessel);
			}
		}
		return null;
	}

	protected function getFirst(People $people): Unit {
		$people->rewind();
		/** @var Unit $unit */
		$unit = $people->current();
		return $unit;
	}

	protected function getRandom(People $people): Unit {
		/** @var Unit $unit */
		$unit = $people->random();
		return $unit;
	}
}
