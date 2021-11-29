<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Protection\Woodshield;
use Lemuria\Model\Fantasya\Shield;

/**
 * A split wood shield.
 */
final class SplitWoodshield extends AbstractRepairable implements Shield
{
	#[Pure] public function Weight(): int {
		return Woodshield::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return $this->reduceBlock(Woodshield::BLOCK);
	}

	#[Pure] protected function protection(): string {
		return Woodshield::class;
	}
}
