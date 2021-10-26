<?php
declare(strict_types = 1);
namespace Lemuria\Model\Fantasya;

/**
 * @noinspection PhpMultipleClassDeclarationsInspection
 */
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

	public function __toString(): string {
		return $this->count . 'd' . $this->dice . '+' . $this->addition;
	}
}
