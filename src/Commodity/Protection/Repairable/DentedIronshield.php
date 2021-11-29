<?php
declare (strict_types = 1);
namespace Lemuria\Model\Fantasya\Commodity\Protection\Repairable;

use JetBrains\PhpStorm\Pure;

use Lemuria\Model\Fantasya\Commodity\Protection\Ironshield;
use Lemuria\Model\Fantasya\Shield;

/**
 * A dented iron shield.
 */
final class DentedIronshield extends AbstractRepairable implements Shield
{
	#[Pure] public function Weight(): int {
		return Ironshield::WEIGHT;
	}

	#[Pure] public function Block(): int {
		return $this->reduceBlock(Ironshield::BLOCK);
	}

	#[Pure] protected function protection(): string {
		return Ironshield::class;
	}
}
