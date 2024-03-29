<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

class Damage implements \Stringable
{
	public function __construct(protected int $count, protected int $dice, protected int $addition) {
	}

	public function Count(): int {
		return $this->count;
	}

	public function Dice(): int {
		return $this->dice;
	}

	public function Addition(): int {
		return $this->addition;
	}

	public function Maximum(): int {
		return $this->count * $this->dice + $this->addition;
	}

	public function __toString(): string {
		return $this->count . 'd' . $this->dice . '+' . $this->addition;
	}

	public function reducedBy(float $reduction): static {
		$this->dice     = (int)ceil((1.0 - $reduction) * $this->dice);
		$this->addition = (int)ceil((1.0 - $reduction) * $this->addition);
		return $this;
	}
}
