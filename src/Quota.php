<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

class Quota
{
	public function __construct(protected Commodity $commodity, protected int|float $threshold) {
	}

	public function Commodity(): Commodity {
		return $this->commodity;
	}

	public function Threshold(): int|float {
		return $this->threshold;
	}

	public function setThreshold(int|float $threshold): Quota {
		$this->threshold = $threshold;
		return $this;
	}
}
